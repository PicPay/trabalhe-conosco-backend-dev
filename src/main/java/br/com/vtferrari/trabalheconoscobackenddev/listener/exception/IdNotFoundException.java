package br.com.vtferrari.trabalheconoscobackenddev.listener.exception;

public class IdNotFoundException extends RuntimeException {

    public IdNotFoundException(String message) {
        super(message);
    }
}
