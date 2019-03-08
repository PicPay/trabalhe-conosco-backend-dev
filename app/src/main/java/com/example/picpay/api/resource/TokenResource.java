package com.example.picpay.api.resource;

import javax.servlet.http.Cookie;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import org.springframework.http.HttpStatus;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseStatus;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping("/tokens")
public class TokenResource {

  @DeleteMapping("/revoke")
  @ResponseStatus(HttpStatus.NO_CONTENT)
  public void revoke(HttpServletRequest req, HttpServletResponse resp) {
    Cookie cookie = new Cookie("refreshToken", null);
    cookie.setHttpOnly(true);
    cookie.setSecure(false); // https não configurável
    cookie.setPath(req.getContextPath() + "/oauth/token");
    cookie.setMaxAge(0);
    resp.addCookie(cookie);
  }

}
