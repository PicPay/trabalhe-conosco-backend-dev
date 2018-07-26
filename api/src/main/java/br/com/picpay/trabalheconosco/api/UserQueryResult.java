package br.com.picpay.trabalheconosco.api;

import java.util.stream.Stream;

public interface UserQueryResult {

	long total();
	
	Stream<User> users();

}
