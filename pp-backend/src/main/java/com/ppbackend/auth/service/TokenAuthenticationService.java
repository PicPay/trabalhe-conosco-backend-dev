package com.ppbackend.auth.service;

import io.jsonwebtoken.Jwts;
import io.jsonwebtoken.SignatureAlgorithm;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.Authentication;
import org.springframework.util.StringUtils;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.util.Collections;
import java.util.Date;

public class TokenAuthenticationService {

    static long EXPIRATION_TIME = 860_000_000;
    static String SECRET = "p2wk1yZrfVQwWMS88vQKoE4QDYhGVqoFzYiQli4IYDnszeRaOZuYQ91v3z07BOhUfKRTEpVeF5Du6tyLUU9saVegPhx3MQJ7f1DmAye5nCM3UKfNUJdw3LL9fVg4vIZhjT8G9XwmtupITqyrZBlNSr6iVfAvKtQvjJLojE";
    static final String TOKEN_PREFIX = "Bearer";
    static final String HEADER_STRING = "Authorization";

    public static void addAuthentication(HttpServletResponse response, String username)
            throws IOException {
        String JWT = Jwts.builder()
                .setSubject(username)
                .setExpiration(new Date(System.currentTimeMillis() + EXPIRATION_TIME))
                .signWith(SignatureAlgorithm.HS512, SECRET)
                .compact();

        response.getWriter().print("{ \"token\" : \"" + TOKEN_PREFIX + " " + JWT + "\"}");
        response.setStatus(HttpServletResponse.SC_OK);
        response.addHeader(HEADER_STRING, TOKEN_PREFIX + " " + JWT);
    }

    public static Authentication getAuthentication(HttpServletRequest request) {
        String token = request.getHeader(HEADER_STRING);
        String user = auth(token);

        if (!StringUtils.isEmpty(user)) {
            return new UsernamePasswordAuthenticationToken(user, null, Collections.emptyList());
        }
        return null;
    }

    public static String auth(String token) {
        if (!StringUtils.isEmpty(token)) {
            return Jwts.parser()
                    .setSigningKey(SECRET)
                    .parseClaimsJws(token.replace(TOKEN_PREFIX, ""))
                    .getBody()
                    .getSubject();
        }
        return null;
    }
}
