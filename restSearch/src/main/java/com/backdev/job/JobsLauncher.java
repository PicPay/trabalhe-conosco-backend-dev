package com.backdev.job;

import org.springframework.batch.core.*;
import org.springframework.batch.core.configuration.annotation.DefaultBatchConfigurer;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.elasticsearch.core.ElasticsearchTemplate;
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

    @PostConstruct
    private void init() throws Exception {
        System.out.println(" Job Started at :" + new Date());

        JobParameters param = new JobParametersBuilder()
                .addString("JobID",String.valueOf(System.currentTimeMillis()))
                .toJobParameters();

//        SimpleJobLauncher jobLauncher = new SimpleJobLauncher();
//        jobLauncher.setJobRepository(getJobRepository());
//        jobLauncher.setTaskExecutor(new SimpleAsyncTaskExecutor());
//        jobLauncher.afterPropertiesSet();
//        JobExecution execution = jobLauncher.run(readTxtFile, param);
//        JobExecution execution = jobLauncher.run(readCsvFile, param);
//        JobExecution execution = getJobLauncher().run(readCsvFile, param);
//        System.out.println("Job finished with status :" + execution.getStatus() + " at "  + new Date());
    }
}
