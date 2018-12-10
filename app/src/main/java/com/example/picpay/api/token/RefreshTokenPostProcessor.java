
package com.example.picpay.api.token;

import javax.servlet.http.Cookie;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import org.springframework.core.MethodParameter;
import org.springframework.http.MediaType;
import org.springframework.http.converter.HttpMessageConverter;
import org.springframework.http.server.ServerHttpRequest;
import org.springframework.http.server.ServerHttpResponse;
import org.springframework.http.server.ServletServerHttpRequest;
import org.springframework.http.server.ServletServerHttpResponse;
import org.springframework.security.oauth2.common.DefaultOAuth2AccessToken;
import org.springframework.security.oauth2.common.OAuth2AccessToken;
import org.springframework.web.bind.annotation.ControllerAdvice;
import org.springframework.web.servlet.mvc.method.annotation.ResponseBodyAdvice;

@ControllerAdvice
public class RefreshTokenPostProcessor implements ResponseBodyAdvice<OAuth2AccessToken> {

  public static final String REFRESH_TOKEN_COOKIE_NAME = "refreshToken";

  @Override
  public boolean supports(MethodParameter returnType,
      Class<? extends HttpMessageConverter<?>> converterType) {
    return returnType.getMethod().getName().equals("postAccessToken");
  }

  @Override
  public OAuth2AccessToken beforeBodyWrite(OAuth2AccessToken body, MethodParameter returnType,
      MediaType selectedContentType, Class<? extends HttpMessageConverter<?>> selectedConverterType,
      ServerHttpRequest request, ServerHttpResponse response) {
    HttpServletRequest req = ((ServletServerHttpRequest) request).getServletRequest();
    HttpServletResponse res = ((ServletServerHttpResponse) response).getServletResponse();

    String refreshToken = body.getRefreshToken().getValue();
    this.createRefreshTokenSafeCookie(req, res, refreshToken);

    DefaultOAuth2AccessToken token = (DefaultOAuth2AccessToken) body;
    this.removeRefreshTokenFromBody(token);

    return body;
  }

  private void removeRefreshTokenFromBody(DefaultOAuth2AccessToken token) {
    token.setRefreshToken(null);
  }

  private void createRefreshTokenSafeCookie(HttpServletRequest req, HttpServletResponse res,
      String refreshToken) {
    Cookie cookie = new Cookie(REFRESH_TOKEN_COOKIE_NAME, refreshToken);
    cookie.setHttpOnly(true);
    cookie.setSecure(false); // https não configurável
    cookie.setPath(req.getContextPath() + "/oauth/token");
    cookie.setMaxAge(2592000);
    res.addCookie(cookie);
  }

}
