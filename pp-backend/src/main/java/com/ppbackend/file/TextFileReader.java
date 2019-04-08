package com.ppbackend.file;

import com.ppbackend.file.processors.Uuid;
import com.ppbackend.file.processors.UuidProcessor;
import com.ppbackend.file.processors.UuidWriter;
import com.ppbackend.user.model.User;
import org.springframework.batch.core.Job;
import org.springframework.batch.core.Step;
import org.springframework.batch.core.configuration.annotation.EnableBatchProcessing;
import org.springframework.batch.core.configuration.annotation.JobBuilderFactory;
import org.springframework.batch.core.configuration.annotation.StepBuilderFactory;
import org.springframework.batch.core.launch.support.RunIdIncrementer;
import org.springframework.batch.item.file.FlatFileItemReader;
import org.springframework.batch.item.file.FlatFileParseException;
import org.springframework.batch.item.file.MultiResourceItemReader;
import org.springframework.batch.item.file.mapping.BeanWrapperFieldSetMapper;
import org.springframework.batch.item.file.mapping.DefaultLineMapper;
import org.springframework.batch.item.file.transform.DelimitedLineTokenizer;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.core.io.ClassPathResource;
import org.springframework.core.io.Resource;

@EnableBatchProcessing
@Configuration
public class TextFileReader implements FileProcessor<User> {

    @Autowired
    public JobBuilderFactory jobBuilderFactory;
    @Autowired
    public StepBuilderFactory stepBuilderFactory;
    @Autowired
    private UuidWriter uuidWriter;
    @Autowired
    private UuidProcessor uuidProcessor;

    @Bean(name = "multiFileReader")
    public MultiResourceItemReader<Uuid> multiReader() {
        MultiResourceItemReader<Uuid> itemReader = new MultiResourceItemReader<>();
        Resource[] resources = {new ClassPathResource("lista_relevancia_1.txt"),
                new ClassPathResource("lista_relevancia_2.txt")};
        itemReader.setResources(resources);
        itemReader.setDelegate(reader());
        return itemReader;
    }

    @Bean(name = "fileReader")
    @Override
    public FlatFileItemReader<Uuid> reader() {
        FlatFileItemReader<Uuid> reader = new FlatFileItemReader<Uuid>();
        reader.setResource(new ClassPathResource("lista_relevancia_1.txt"));
        reader.setLineMapper(new DefaultLineMapper<>() {{
            setLineTokenizer(new DelimitedLineTokenizer() {{
                setNames("uuid");
            }});
            setFieldSetMapper(new BeanWrapperFieldSetMapper<Uuid>() {{
                setTargetType(Uuid.class);
            }});
        }});
        return reader;
    }

    @Override
    @Bean(name = "txtFileToDatabaseStep")
    public Step fileToDatabaseStep() {
        return stepBuilderFactory.get("txtFileToDatabaseStep")
                .<Uuid, Uuid>chunk(200)
                .reader(multiReader()).faultTolerant().skipLimit(10)
                .skip(FlatFileParseException.class)
                .processor(uuidProcessor)
                .writer(uuidWriter)
                .build();
    }

    @Override
    @Bean(name = "readTxtFile")
    public Job readFile() {
        return jobBuilderFactory.get("readTxtFile")
                .incrementer(new RunIdIncrementer())
                .start(fileToDatabaseStep())
                .build();
    }

    public UuidProcessor getUuidProcessor() {
        return uuidProcessor;
    }

    public UuidWriter getUuidWriter() {
        return uuidWriter;
    }
}
