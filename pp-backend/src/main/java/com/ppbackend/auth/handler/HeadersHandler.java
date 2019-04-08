package com.ppbackend.auth.handler;

import org.springframework.stereotype.Component;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;

@Component
public class HeadersHandler {
    static final String OPTIONS = "OPTIONS";
    static final String OK = "OK";
    static final String ALL = "*";
    static final String TRUE = "true";


    public void process(HttpServletRequest request, HttpServletResponse response)
            throws IOException {
        response.setHeader("Access-Control-Allow-Origin", ALL);
        response.setHeader("Access-Control-Allow-Credentials",TRUE);
        response.setHeader("Access-Control-Allow-Methods",
                "GET, HEAD,OPTIONS, POST");
        response.setHeader("Access-Control-Allow-Headers",
                "Origin, X-Requested-With, Content-Type, Accept, Key, Authorization");

        if (request.getMethod().equals(OPTIONS)) {
            response.getWriter().print(OK);
            response.getWriter().flush();
        }
    }
}
