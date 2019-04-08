package com.ppbackend.auth.handler;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.AuthenticationException;
import org.springframework.security.web.AuthenticationEntryPoint;
import org.springframework.stereotype.Component;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;

@Component
public class HttpUnauthorizedAuthEntryPoint implements AuthenticationEntryPoint {

    private static final Logger LOGGER = LoggerFactory.getLogger(HttpUnauthorizedAuthEntryPoint.class);

    @Autowired
    HeadersHandler headerHandler;

    public void commence(HttpServletRequest request, HttpServletResponse response, AuthenticationException authException)
            throws IOException, ServletException {
        LOGGER.debug("Pre-authenticated entry point called. Rejecting access:" + request.getRequestURL());
        headerHandler.process(request, response);
        response.sendError(HttpServletResponse.SC_UNAUTHORIZED, "Access Denied");
    }
}
