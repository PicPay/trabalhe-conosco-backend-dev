package com.ppbackend.file.job;

import org.springframework.batch.core.Job;
import org.springframework.batch.core.JobExecution;
import org.springframework.batch.core.JobParameters;
import org.springframework.batch.core.JobParametersBuilder;
import org.springframework.batch.core.configuration.annotation.DefaultBatchConfigurer;
import org.springframework.batch.core.launch.JobLauncher;
import org.springframework.batch.core.launch.support.SimpleJobLauncher;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.ExitCodeGenerator;
import org.springframework.boot.SpringApplication;
import org.springframework.context.ApplicationContext;
import org.springframework.context.ConfigurableApplicationContext;
import org.springframework.context.annotation.Bean;
import org.springframework.core.task.TaskExecutor;
import org.springframework.data.elasticsearch.core.ElasticsearchTemplate;
import org.springframework.scheduling.concurrent.ThreadPoolTaskExecutor;
import org.springframework.stereotype.Component;

import javax.annotation.PostConstruct;
import java.util.Date;

@Component
public class JobsLauncher extends DefaultBatchConfigurer {

    @Autowired
    private Job readCsvFile;
    @Autowired
    private Job readTxtFile;
    @Autowired
    private ElasticsearchTemplate elasticsearchTemplate;

    @Bean
    private TaskExecutor taskExecutor() {
        ThreadPoolTaskExecutor taskExecutor = new ThreadPoolTaskExecutor();
        taskExecutor.setMaxPoolSize(10);
        taskExecutor.setQueueCapacity(16);
        taskExecutor.afterPropertiesSet();
        return taskExecutor;
    }

    private JobLauncher jobLaunch() throws Exception {
        SimpleJobLauncher jobLauncher = new SimpleJobLauncher();
        jobLauncher.setJobRepository(getJobRepository());
        jobLauncher.setTaskExecutor(taskExecutor());
        jobLauncher.afterPropertiesSet();
        return jobLauncher;
    }

    private JobParameters getJobParams() {
        return new JobParametersBuilder()
                .addString("JobID", String.valueOf(System.currentTimeMillis()))
                .toJobParameters();
    }

    public void loadUsersList() throws Exception {
        System.out.println(" Job Started at :" + new Date());
        JobExecution execution = jobLaunch().run(readCsvFile, getJobParams());
        System.out.println("Job finished with status :" + execution.getStatus() + " at " + new Date());
    }

    public void loadRelevanceList() throws Exception {
        System.out.println(" Job Started at :" + new Date());
        JobExecution execution = jobLaunch().run(readTxtFile, getJobParams());
        System.out.println("Job finished with status :" + execution.getStatus() + " at " + new Date());
    }

    //@PostConstruct
    public void loadAll() throws Exception {
        System.out.println("File load Job Started at :" + new Date());
        JobExecution execution = jobLaunch().run(readCsvFile, getJobParams());
        System.out.println("Job finished with status :" + execution.getStatus() + " at " + new Date());
    }
}
