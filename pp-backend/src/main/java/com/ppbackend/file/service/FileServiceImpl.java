package com.ppbackend.file.service;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import com.ppbackend.file.job.*;

@Service
public class FileServiceImpl implements FileService {

    private static Logger LOGGER = LoggerFactory.getLogger(FileServiceImpl.class);

    @Autowired
    private JobsLauncher jobsLauncher;

    @Override
    public void synchUsers() throws Exception {
        LOGGER.info("synchUsers method called");
        jobsLauncher.loadUsersList();
    }

    @Override
    public void synchRelevancyList() throws Exception {
        LOGGER.info("synchRelevancyList method called");
        jobsLauncher.loadRelevanceList();
    }
}
