package br.com.picpay.challenge.backend;

import java.util.stream.Collectors;

import javax.servlet.http.HttpServletResponse;
import javax.validation.ConstraintViolationException;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.MessageSource;
import org.springframework.http.HttpHeaders;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.MethodArgumentNotValidException;
import org.springframework.web.bind.annotation.ExceptionHandler;
import org.springframework.web.bind.annotation.RestControllerAdvice;
import org.springframework.web.context.request.WebRequest;
import org.springframework.web.servlet.mvc.method.annotation.ResponseEntityExceptionHandler;

@RestControllerAdvice
public class ExceptionHandlerController extends ResponseEntityExceptionHandler {

	private static final Logger logger = LoggerFactory.getLogger(ExceptionHandlerController.class);
	
	@Autowired
	private MessageSource messageSource;
	
	@Override
	protected ResponseEntity<Object> handleMethodArgumentNotValid(MethodArgumentNotValidException ex, HttpHeaders headers, HttpStatus status, WebRequest request) {
		//Mostra os errors de forma simples, não trata internacionalização
		BindingResult bindingResult = ex.getBindingResult(); 
		String errors = bindingResult.getAllErrors()
			.stream()
			.map(error -> messageSource.getMessage(error, null))
			.collect(Collectors.joining(","));
		ResponseError body = new ResponseError(HttpServletResponse.SC_BAD_REQUEST, errors);
		return handleExceptionInternal(ex, body, new HttpHeaders(), HttpStatus.BAD_REQUEST, request);
	}
	
	@ExceptionHandler(ConstraintViolationException.class)
	ResponseEntity<Object> handleConstraintViolationException(ConstraintViolationException ex, WebRequest request) {
		HttpStatus status = HttpStatus.BAD_REQUEST;
		ResponseError body = new ResponseError(status.value(), ex.getMessage());
		return handleExceptionInternal(ex, body, new HttpHeaders(), status, request);
	}
	
	@ExceptionHandler(BackendException.class)
	ResponseEntity<Object> handleBackendException(BackendException ex, WebRequest request) {
		ResponseError body = null;
		HttpStatus status = HttpStatus.INTERNAL_SERVER_ERROR;
		if (ex.getResponseError() != null) {
			body = ex.getResponseError();
			status = HttpStatus.valueOf(body.getStatus());
		}
		return handleExceptionInternal(ex, body, new HttpHeaders(), status, request);
	}
	
	@ExceptionHandler(Exception.class)
	ResponseEntity<Object> handleAnyException(Exception ex, WebRequest request) {
		logger.error(ex.getMessage(), ex);
		HttpStatus status = HttpStatus.INTERNAL_SERVER_ERROR;
		ResponseError body = new ResponseError(status.value(), "Ocorreu um erro durante o processamento da requisição. :-(");
		return handleExceptionInternal(ex, body, new HttpHeaders(), status, request);
	}
	
}
