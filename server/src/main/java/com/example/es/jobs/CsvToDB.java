package com.example.es.jobs;

import java.util.Arrays;
import java.util.List;

import com.example.es.domain.UsrData;
import com.example.es.repository.es.UsrDataRepository;
import org.elasticsearch.action.bulk.BulkRequestBuilder;
import org.elasticsearch.action.update.UpdateRequest;
import org.elasticsearch.client.Client;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.batch.core.Job;
import org.springframework.batch.core.JobExecution;
import org.springframework.batch.core.JobExecutionListener;
import org.springframework.batch.core.Step;
import org.springframework.batch.core.configuration.annotation.DefaultBatchConfigurer;
import org.springframework.batch.core.configuration.annotation.EnableBatchProcessing;
import org.springframework.batch.core.configuration.annotation.JobBuilderFactory;
import org.springframework.batch.core.configuration.annotation.StepBuilderFactory;
import org.springframework.batch.core.launch.support.RunIdIncrementer;
import org.springframework.batch.item.ItemWriter;
import org.springframework.batch.item.data.MongoItemWriter;
import org.springframework.batch.item.file.FlatFileItemReader;
import org.springframework.batch.item.file.mapping.BeanWrapperFieldSetMapper;
import org.springframework.batch.item.file.mapping.DefaultLineMapper;
import org.springframework.batch.item.file.mapping.PassThroughLineMapper;
import org.springframework.batch.item.file.transform.DelimitedLineTokenizer;
import org.springframework.batch.item.support.CompositeItemWriter;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.core.io.ClassPathResource;
import org.springframework.core.task.SimpleAsyncTaskExecutor;
import org.springframework.core.task.TaskExecutor;
import org.springframework.data.mongodb.core.MongoTemplate;
import org.springframework.data.mongodb.core.query.Criteria;
import org.springframework.data.mongodb.core.query.Query;
import org.springframework.data.mongodb.core.query.Update;
import org.springframework.util.StopWatch;

@EnableBatchProcessing
@Configuration
public class CsvToDB extends DefaultBatchConfigurer {

    @Autowired
    private JobBuilderFactory jobBuilderFactory;
    @Autowired
    private StepBuilderFactory stepBuilderFactory;
    @Autowired
    private MongoTemplate mongoTemplate;
    @Autowired
    private UsrDataRepository usrDataRepository;
    @Autowired
    private Client elasticSearchClient;

    /*
     * Declaração e configuração do Job para leitura do arquivo csv e importação
     * para o Mongodb e ElasticSeach
     */

    
    @Bean
    public Job readCSVFile() {
        return jobBuilderFactory.get("readCSVFile").incrementer(new RunIdIncrementer())
        .start(step1())
        .next(step2())
                .next(step3())
                .listener(new ExecutionTimeJobListener()).build();
    }

    class ExecutionTimeJobListener implements JobExecutionListener {

        private Logger logger = LoggerFactory.getLogger(ExecutionTimeJobListener.class);
        private StopWatch stopWatch = new StopWatch();

        @Override
        public void beforeJob(JobExecution jobExecution) {
            stopWatch.start();
        }

        @Override
        public void afterJob(JobExecution jobExecution) {
            stopWatch.stop();
            logger.info("Job took " + stopWatch.getTotalTimeSeconds() + "s");
        }

    }

    @Bean
    public TaskExecutor taskExecutor() {
        SimpleAsyncTaskExecutor taskExecutor = new SimpleAsyncTaskExecutor();
        taskExecutor.setConcurrencyLimit(2);
        return taskExecutor;
    }

    /*
     * Declaração e configuração do Setp 1 que faz a leitura do arquivo csv e
     * importa para Mongodb e ElasticSerach
     */

    @Bean
    public Step step1() {
        return stepBuilderFactory.get("step1").<UsrData, UsrData>chunk(100).reader(reader())
                .writer(compositeItemWriter()).taskExecutor(taskExecutor()).throttleLimit(2).build();
    }

    @Bean
    public FlatFileItemReader<UsrData> reader() {
        FlatFileItemReader<UsrData> reader = new FlatFileItemReader<>();
        reader.setResource(new ClassPathResource("users.csv"));
        reader.setLineMapper(new DefaultLineMapper<UsrData>() {
            {
                setLineTokenizer(new DelimitedLineTokenizer() {
                    {
                        setNames(new String[] { "uuid", "name", "username" });

                    }
                });
                setFieldSetMapper(new BeanWrapperFieldSetMapper<UsrData>() {
                    {
                        setTargetType(UsrData.class);
                    }
                });
            }
        });
        return reader;
    }

    public ItemWriter<UsrData> esWriter() {
        ItemWriter<UsrData> writer = new ItemWriter<UsrData>() {

            @Override
            public void write(List<? extends UsrData> items) throws Exception {
                usrDataRepository.saveAll(items);
            }
        };
        return writer;
    }

    @Bean
    public MongoItemWriter<UsrData> mongoWriter() {
        MongoItemWriter<UsrData> writer = new MongoItemWriter<UsrData>();
        writer.setTemplate(mongoTemplate);
        writer.setCollection("usrData");
        return writer;
    }

    @Bean
    public CompositeItemWriter<UsrData> compositeItemWriter() {
        CompositeItemWriter<UsrData> compositeItemWriter = new CompositeItemWriter<>();
        compositeItemWriter.setDelegates(Arrays.asList(esWriter(), mongoWriter()));
        return compositeItemWriter;
    }

     /*
     * Reader e Writer para os steps 2 e 3 que atualizam os indices com as listas de relevância     
     */


    public FlatFileItemReader<String> readerVip(String file) {
        FlatFileItemReader<String> reader = new FlatFileItemReader<>();
        reader.setResource(new ClassPathResource(file));
        reader.setEncoding("UTF-8");
        reader.setLineMapper(new PassThroughLineMapper());
        return reader;
    }

    public ItemWriter<String> mongoUpdateVip(String field) {
        ItemWriter<String> writer = new ItemWriter<String>() {

            @Override
            public void write(List<? extends String> items) throws Exception {                

                mongoTemplate.updateMulti(new Query(Criteria.where("_id").in(items)), Update.update(field, true),
                        UsrData.class);               
            }
        };
        return writer;
    }

    public ItemWriter<String> esUpdateVip(String field, String index, String type) {
        ItemWriter<String> writer = new ItemWriter<String>() {

            @Override
            public void write(List<? extends String> items) throws Exception {

                BulkRequestBuilder bulkRequestBuilder = elasticSearchClient.prepareBulk();

                items.forEach(id -> {
                    UpdateRequest updateRequest = elasticSearchClient.prepareUpdate().setType(type).setIndex(index)
                            .setId(id).setDoc(field, true).request();

                    bulkRequestBuilder.add(updateRequest);
                });

                bulkRequestBuilder.get();
            }
        };
        return writer;
    }

    public CompositeItemWriter<String> compositeItemUpdateVip(String field, String index, String type) {
        CompositeItemWriter<String> compositeItemWriter = new CompositeItemWriter<>();
        compositeItemWriter.setDelegates(Arrays.asList(esUpdateVip(field, index, type), mongoUpdateVip(field)));
        return compositeItemWriter;
    }

    /*
     * Declaração e configuração do Setp 2 que faz a leitura da lista de relevância
     * 1 e faz o update no Mongodb e ElasticSerach
     */
    @Bean
    public Step step2() {
        return stepBuilderFactory.get("step2").<String, String>chunk(100).reader(readerVip("lista_relevancia_1.txt"))
                .writer(compositeItemUpdateVip("vip1", "usrpic", "users")).taskExecutor(taskExecutor()).throttleLimit(1)
                .build();
    }    

    /*
     * Declaração e configuração do Setp 3 que faz a leitura da lista de relevância
     * 1 e faz o update no Mongodb e ElasticSerach
     */

    @Bean
    public Step step3() {
        return stepBuilderFactory.get("step3").<String, String>chunk(100).reader(readerVip("lista_relevancia_2.txt"))
                .writer(compositeItemUpdateVip("vip2", "usrpic", "users"))
                .taskExecutor(taskExecutor()).throttleLimit(1).build();
    }
}