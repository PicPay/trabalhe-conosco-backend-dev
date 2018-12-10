
package com.example.picpay.api.token;

import java.io.IOException;
import java.util.Map;
import javax.servlet.Filter;
import javax.servlet.FilterChain;
import javax.servlet.FilterConfig;
import javax.servlet.ServletException;
import javax.servlet.ServletRequest;
import javax.servlet.ServletResponse;
import javax.servlet.http.Cookie;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletRequestWrapper;
import org.apache.catalina.util.ParameterMap;
import org.springframework.core.Ordered;
import org.springframework.core.annotation.Order;
import org.springframework.stereotype.Component;

@Component
@Order(Ordered.HIGHEST_PRECEDENCE)
public class RefreshTokenPreProcessorFilter implements Filter {

  /**
   * Interceptando com alta prioridade as requisições que possuem um grant_type = 'refresh_token'
   * chamarem o endpoint "/oauth/token"
   */
  @Override
  public void doFilter(ServletRequest request, ServletResponse response, FilterChain chain)
      throws IOException, ServletException {
    HttpServletRequest req = (HttpServletRequest) request;
    if ("/oauth/token".equalsIgnoreCase(req.getRequestURI())
        && "refresh_token".equalsIgnoreCase(req.getParameter("grant_type"))
        && req.getCookies() != null) {
      for (Cookie cookie : req.getCookies()) {
        if (cookie.getName().equals("refreshToken")) {
          String refreshToken = cookie.getValue();
          req = new MyServletRequestWrapper(req, refreshToken);
        }
      }
    }

    // Continua a cadeia com a nova requisição que possui o novo parâmetro
    chain.doFilter(req, response);
  }

  @Override
  public void init(FilterConfig filterConfig) throws ServletException {}

  @Override
  public void destroy() {}

  /*
   * Sobrescrevendo o request e passando a requisição com o mapa de parametros atualizado com o
   * refreshToken - Desta forma o OAuth2 irá recuperar normalmente o refreshToken, como se estivesse
   * vindo direto da requisição
   */

  static class MyServletRequestWrapper extends HttpServletRequestWrapper {

    private String refreshToken;

    public MyServletRequestWrapper(HttpServletRequest request, String refreshToken) {
      super(request);
      this.refreshToken = refreshToken;
    }

    @Override
    public Map<String, String[]> getParameterMap() {
      ParameterMap<String, String[]> map = new ParameterMap<>(getRequest().getParameterMap());
      map.put("refresh_token", new String[] {refreshToken});
      map.setLocked(true);
      return map;
    }

  }

}
