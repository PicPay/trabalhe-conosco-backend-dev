package com.backdev.file;

import com.backdev.file.resources.Uuid;
import com.backdev.file.resources.UuidProcessor;
import com.backdev.file.resources.UuidWriter;
import com.backdev.user.entity.User;
import org.springframework.batch.core.Job;
import org.springframework.batch.core.Step;
import org.springframework.batch.core.configuration.annotation.EnableBatchProcessing;
import org.springframework.batch.core.configuration.annotation.JobBuilderFactory;
import org.springframework.batch.core.configuration.annotation.StepBuilderFactory;
import org.springframework.batch.core.launch.support.RunIdIncrementer;
import org.springframework.batch.item.file.FlatFileItemReader;
import org.springframework.batch.item.file.mapping.BeanWrapperFieldSetMapper;
import org.springframework.batch.item.file.mapping.DefaultLineMapper;
import org.springframework.batch.item.file.transform.DelimitedLineTokenizer;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.core.io.ClassPathResource;

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

    @Bean(name = "fileReader")
    @Override
    public FlatFileItemReader<Uuid> reader() {
        FlatFileItemReader<Uuid> reader = new FlatFileItemReader<Uuid>();
        reader.setResource(new ClassPathResource("lista_relevancia_1.txt"));
        reader.setLineMapper(new DefaultLineMapper<Uuid>() {{
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
                .<Uuid, Uuid>chunk(10)
                .reader(reader())
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
}
