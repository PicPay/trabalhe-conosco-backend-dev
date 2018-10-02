/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package br.com.apiresttestpicpay.service;

import br.com.apiresttestpicpay.model.Prioridade1;
import br.com.apiresttestpicpay.model.Prioridade1_;
import br.com.apiresttestpicpay.model.Prioridade2;
import br.com.apiresttestpicpay.model.Prioridade2_;
import br.com.apiresttestpicpay.model.Users;
import br.com.apiresttestpicpay.model.Users_;
import java.io.Serializable;
import java.util.List;
import javax.ejb.Stateless;
import javax.inject.Inject;
import javax.persistence.EntityManager;
import javax.persistence.Query;
import javax.persistence.criteria.CriteriaBuilder;
import javax.persistence.criteria.CriteriaQuery;
import javax.persistence.criteria.Predicate;
import javax.persistence.criteria.Root;
import javax.persistence.criteria.Subquery;

/**
 *
 * @author rsilva
 */
@Stateless
public class UsersSrv implements Serializable {

    @Inject
    protected EntityManager em;

    public List<Users> findUsersEntities() {
        return findUsersEntities(true, -1, -1, null);
    }

    public List<Users> findUsersEntities(int maxResults, int firstResult, String term) {
        return findUsersEntities(false, maxResults, firstResult, term);
    }

    private List<Users> findUsersEntities(boolean all, int maxResults, int firstResult, String term) {
        Query q = em.createQuery(createCriteria(term, false, true, false));
        if (!all) {
            q.setMaxResults(maxResults);
            q.setFirstResult(firstResult);
        }
        List<Users> resultQuery = q.getResultList();

        if (resultQuery.size() < maxResults) {
            q = em.createQuery(createCriteria(term, false, false, true));
            if (!all) {
                q.setMaxResults(maxResults - resultQuery.size());
                q.setFirstResult(firstResult + resultQuery.size());
            }
            resultQuery.addAll(q.getResultList());
        }

        if (resultQuery.size() < maxResults) {
            q = em.createQuery(createCriteria(term, false, false, false));
            if (!all) {
                q.setMaxResults(maxResults - resultQuery.size());
                q.setFirstResult(firstResult + resultQuery.size());
            }
            resultQuery.addAll(q.getResultList());
        }

        return resultQuery;
    }

    public Users findUsers(String id) {
        return em.find(Users.class, id);
    }

    public int getUsersCount(String term) {
        Query q;
        int count = 0;

        q = em.createQuery(createCriteria(term, true, true, false));
        count += ((Long) q.getSingleResult()).intValue();

        q = em.createQuery(createCriteria(term, true, false, true));
        count += ((Long) q.getSingleResult()).intValue();

        q = em.createQuery(createCriteria(term, true, false, false));
        count += ((Long) q.getSingleResult()).intValue();

        return count;
    }

    public CriteriaQuery createCriteria(String term, boolean count, boolean prio1, boolean prio2) {
        CriteriaBuilder cb = em.getCriteriaBuilder();
        CriteriaQuery cq = cb.createQuery();

        Root<Users> from = cq.from(Users.class);

        Subquery<Prioridade1> subQueryP1 = cq.subquery(Prioridade1.class);
        Root<Prioridade1> fromP1 = subQueryP1.from(Prioridade1.class);
        subQueryP1.select(fromP1);
        subQueryP1.where(cb.and(cb.equal(from.get(Users_.id), fromP1.get(Prioridade1_.id))));

        Subquery<Prioridade2> subQueryP2 = cq.subquery(Prioridade2.class);
        Root<Prioridade2> fromP2 = subQueryP2.from(Prioridade2.class);
        subQueryP2.select(fromP2);
        subQueryP2.where(cb.and(cb.equal(from.get(Users_.id), fromP2.get(Prioridade2_.id))));

        Predicate predicate = cb.and();
        if (term != null) {
            predicate = cb.and(predicate, cb.like(from.get(Users_.nome), "%" + term + "%"));
            predicate = cb.or(predicate, cb.like(from.get(Users_.username), "%" + term.toLowerCase().trim() + "%"));
        }
        if (prio1) {
            predicate = cb.and(predicate, cb.exists(subQueryP1));
        } else {
            predicate = cb.and(predicate, cb.not(cb.exists(subQueryP1)));
        }
        if (prio2) {
            predicate = cb.and(predicate, cb.exists(subQueryP2));
        } else {
            predicate = cb.and(predicate, cb.not(cb.exists(subQueryP2)));
        }

        cq.where(predicate);

        if (count) {
            cq.select(cb.count(from));
        } else {
            cq.select(from);
            cq.orderBy(cb.asc(from.get(Users_.prioridade1))).orderBy(cb.asc(from.get(Users_.prioridade2))).orderBy(cb.asc(from.get(Users_.nome)));
        }

        return cq;
    }

}
