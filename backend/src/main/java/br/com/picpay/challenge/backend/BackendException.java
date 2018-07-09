package br.com.picpay.challenge.backend;

/**
 * Representa uma exceção genérica tratada pelo backend
 * 
 * @author francofabio
 *
 */
@SuppressWarnings("serial")
public class BackendException extends RuntimeException {
	
	private ResponseError responseError;

	public BackendException() {
		super();
	}

	public BackendException(String message, Throwable cause) {
		super(message, cause);
	}

	public BackendException(String message) {
		super(message);
	}
	
	public BackendException(ResponseError responseError) {
		super(responseError.getMessage());
		this.responseError = responseError;
	}
	
	public ResponseError getResponseError() {
		return responseError;
	}

}
