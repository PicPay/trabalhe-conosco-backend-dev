
package com.example.picpay.api.resource;

import javax.websocket.server.PathParam;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;
import com.example.picpay.api.model.Person;
import com.example.picpay.api.repository.PersonRepository;

@RestController
@RequestMapping("/people")
public class PersonResource {

  @Autowired
  private PersonRepository personRepository;

  @GetMapping
  @PreAuthorize("hasAuthority('ROLE_SEARCH_PERSON') and #oauth2.hasScope('read')")
  public Page<Person> filtrar(@PathParam("searchString") String searchString, Pageable pageable) {
    // @PageableDefault(size = 15)) {
    return personRepository.filtrar(searchString, pageable);
  }

}
