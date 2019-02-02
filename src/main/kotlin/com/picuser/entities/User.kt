package com.picuser.entities

import org.springframework.data.annotation.Id
import org.springframework.data.elasticsearch.annotations.Document
import org.springframework.data.elasticsearch.annotations.Field
import org.springframework.data.elasticsearch.annotations.FieldType
import org.springframework.data.elasticsearch.annotations.Setting

@Document(indexName = "users", type = "user")
@Setting(settingPath = "settings.json")
data class User (

    @Id var id: String? = null,

    //@Field(type= FieldType.Text, searchAnalyzer= "search_ngram", analyzer= "index_ngram")
    var userName: String? = null,

    @Field(type= FieldType.Text, searchAnalyzer= "search_ngram", analyzer= "index_ngram")
    var name: String? = null,

    var priority: Int = 0
)