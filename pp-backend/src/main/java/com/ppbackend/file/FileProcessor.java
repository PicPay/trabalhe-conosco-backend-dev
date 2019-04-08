package com.ppbackend.file;

import org.springframework.batch.core.Job;
import org.springframework.batch.core.Step;
import org.springframework.batch.item.file.FlatFileItemReader;

public interface FileProcessor<T> {
    <T> FlatFileItemReader<T> reader();

    Step fileToDatabaseStep();

    Job readFile();
}
