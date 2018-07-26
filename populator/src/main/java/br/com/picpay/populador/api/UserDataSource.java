package br.com.picpay.populador.api;

import java.io.Closeable;
import java.util.stream.Stream;

import br.com.picpay.trabalheconosco.api.User;

public interface UserDataSource extends Closeable {
	
	public Stream<? extends User> asStream();
}
