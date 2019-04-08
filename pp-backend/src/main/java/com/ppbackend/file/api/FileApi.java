package com.ppbackend.file.api;

import com.ppbackend.file.service.FileService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;


@RestController
@RequestMapping(path = "api/file")
public class FileApi {

    @Autowired
    private FileService fileService;

    @GetMapping(value = "/synchRelevancyList")
    public void synchRelevancyList() throws Exception {
        this.fileService.synchRelevancyList();
    }


    @GetMapping(value = "/synchUsersList")
    public void synchUsersList() throws Exception {
        this.fileService.synchUsers();
    }
}
