
package com.example.picpay.api.repository.person;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import com.example.picpay.api.model.Person;

public interface PersonRepositoryQuery {

  public Page<Person> filtrar(String searchString, Pageable pageable);

}
