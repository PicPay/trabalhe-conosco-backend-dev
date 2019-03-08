
package com.example.picpay.api.repository;

import org.springframework.data.jpa.repository.JpaRepository;
import com.example.picpay.api.model.Person;
import com.example.picpay.api.repository.person.PersonRepositoryQuery;

public interface PersonRepository extends JpaRepository<Person, String>, PersonRepositoryQuery {

}
