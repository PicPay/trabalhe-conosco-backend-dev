
package com.example.picpay.api.repository.person;

import java.math.BigInteger;
import javax.persistence.EntityManager;
import javax.persistence.PersistenceContext;
import javax.persistence.Query;
import org.apache.commons.lang3.StringUtils;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageImpl;
import org.springframework.data.domain.Pageable;
import com.example.picpay.api.model.Person;

public class PersonRepositoryImpl implements PersonRepositoryQuery {

  @PersistenceContext
  private EntityManager manager;

  @SuppressWarnings("unchecked")
  @Override
  public Page<Person> filtrar(String searchString, Pageable pageable) {
    String queryStr = " select * from users u ";
    if (StringUtils.isNotEmpty(searchString))
      queryStr += " where match(u.name, u.username) against (:searchString in boolean mode) ";
    queryStr += " order by coalesce(u.priority, 99), u.name limit :firstResult,:maxResults ";

    int currentPage = pageable.getPageNumber();
    int maxResults = pageable.getPageSize();
    int firstResult = currentPage * maxResults;

    Query query = manager.createNativeQuery(queryStr, Person.class);
    if (StringUtils.isNotEmpty(searchString))
      query.setParameter("searchString", searchString);
    query.setParameter("firstResult", firstResult);
    query.setParameter("maxResults", maxResults);

    return new PageImpl<Person>(query.getResultList(), pageable, this.total(searchString));
  }

  private long total(String searchString) {
    String queryCount = " select count(1) from users u ";
    if (StringUtils.isNotEmpty(searchString))
      queryCount += " where match(u.name, u.username) against (:searchString in boolean mode) ";

    Query query = manager.createNativeQuery(queryCount);
    if (StringUtils.isNotEmpty(searchString))
      query.setParameter("searchString", searchString);

    return ((BigInteger) query.getSingleResult()).longValue();
  }

}
