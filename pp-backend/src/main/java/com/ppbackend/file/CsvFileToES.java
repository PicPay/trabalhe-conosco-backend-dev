package com.ppbackend.file;

import com.ppbackend.user.model.User;
import com.ppbackend.user.processors.UserProcessor;
import com.ppbackend.user.processors.UserWriter;
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
public class CsvFileToES implements FileProcessor<User> {

    @Autowired
    public JobBuilderFactory jobBuilderFactory;
    @Autowired
    public StepBuilderFactory stepBuilderFactory;
    @Autowired
    private UserWriter userWriter;
    @Autowired
    private UserProcessor userProcessor;
    @Autowired
    private TextFileReader textFileReader;

    @Bean(name = "csvReader")
    @Override
    public FlatFileItemReader<User> reader() {
        FlatFileItemReader<User> reader = new FlatFileItemReader<User>();
        reader.setResource(new ClassPathResource("users.csv"));
        reader.setLineMapper(new DefaultLineMapper<>() {{
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
                .<User, User>chunk(3000)
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
                .next(textFileReader.fileToDatabaseStep())
                .build();
    }

}