package com.backdev.file;

import com.backdev.user.resources.UserProcessor;
import com.backdev.user.entity.User;
import com.backdev.user.resources.UserWriter;
import org.springframework.batch.core.*;
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
public class CsvFileToES implements FileProcessor<User> {

    @Autowired
    public JobBuilderFactory jobBuilderFactory;
    @Autowired
    public StepBuilderFactory stepBuilderFactory;
    @Autowired
    private UserWriter userWriter;
    @Autowired
    private UserProcessor userProcessor;

    @Bean(name = "csvReader")
    @Override
    public FlatFileItemReader<User> reader() {
        FlatFileItemReader<User> reader = new FlatFileItemReader<User>();
        reader.setResource(new ClassPathResource("users.csv"));
        reader.setLineMapper(new DefaultLineMapper<User>() {{
            setLineTokenizer(new DelimitedLineTokenizer() {{
                setNames(new String[]{"uuid", "name", "username"});
            }});
            setFieldSetMapper(new BeanWrapperFieldSetMapper<User>() {{
                setTargetType(User.class);
            }});
        }});
        return reader;
    }

    @Bean(name = "csvFileToDatabaseStep")
    @Override
    public Step fileToDatabaseStep() {
        return stepBuilderFactory.get("csvFileToDatabaseStep")
                .<User, User>chunk(150)
                .reader(reader())
                .processor(userProcessor)
                .writer(userWriter)
                .build();
    }

    @Bean(name = "readCsvFile")
    @Override
    public Job readFile() {
        return jobBuilderFactory.get("readCSVFile")
                .incrementer(new RunIdIncrementer())
                .start(fileToDatabaseStep())
                .build();
    }

}