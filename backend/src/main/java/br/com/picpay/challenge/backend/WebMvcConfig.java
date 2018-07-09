package br.com.picpay.challenge.backend;

import java.util.List;

import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.web.method.support.HandlerMethodArgumentResolver;
import org.springframework.web.servlet.config.annotation.InterceptorRegistry;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurer;

import br.com.picpay.challenge.backend.argumentresolver.AuthenticatedUserMethodArgumentResolver;
import br.com.picpay.challenge.backend.auth.AuthInterceptor;

@Configuration
public class WebMvcConfig implements WebMvcConfigurer {

	@Bean
	AuthInterceptor authInterceptor() {
		return new AuthInterceptor();
	}
	
	@Bean
	AuthenticatedUserMethodArgumentResolver authenticatedUserArgResolver() {
		return new AuthenticatedUserMethodArgumentResolver();
	}
	
	@Override
	public void addInterceptors(InterceptorRegistry registry) {
		registry.addInterceptor(authInterceptor());
	}

	@Override
	public void addArgumentResolvers(List<HandlerMethodArgumentResolver> resolvers) {
		resolvers.add(authenticatedUserArgResolver());
	}

}
