package br.com.picpay.trabalheconosco.api;

public interface UserIndex {
	
	UserQueryResult query(String keyWord, int page, int pageSize) throws Exception;

	void put(User user, int relevance) throws Exception;
}
