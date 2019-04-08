package com.ppbackend.file.processors;

import org.springframework.data.elasticsearch.repository.ElasticsearchRepository;

public interface UuidRepository extends ElasticsearchRepository<Uuid, String> {
}
