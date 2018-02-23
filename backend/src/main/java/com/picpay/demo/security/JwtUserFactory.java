/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.picpay.demo.security;

import com.picpay.demo.core.Credentials;
import java.util.LinkedList;
import java.util.List;
import org.springframework.security.core.GrantedAuthority;
import org.springframework.security.core.authority.SimpleGrantedAuthority;

/**
 *
 * @author Carlos Eduardo
 */
public class JwtUserFactory {

    public static JwtUser create(Credentials credentials) {
        return new JwtUser(credentials.getUsername(), credentials.getPassword(), getAuthorities());
    }

    private static List<GrantedAuthority> getAuthorities() {
        List<GrantedAuthority> authorities = new LinkedList<>();

        authorities.add(new SimpleGrantedAuthority("admin"));

        return authorities;
    }
}
