package com.example.es.repository.es;

import com.example.es.domain.UsrData;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.elasticsearch.repository.ElasticsearchRepository;

public interface UsrDataRepository extends ElasticsearchRepository<UsrData, String> { 
    
    Page <UsrData> findByNameLikeOrUsernameLikeOrderByVip1DescVip2Desc(String name, String username, Pageable pageable);

}