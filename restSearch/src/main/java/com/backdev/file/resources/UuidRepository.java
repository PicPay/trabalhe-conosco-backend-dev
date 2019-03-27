package com.backdev.file.resources;

import org.springframework.data.elasticsearch.repository.ElasticsearchRepository;

public interface UuidRepository extends ElasticsearchRepository<Uuid, String> {
}
