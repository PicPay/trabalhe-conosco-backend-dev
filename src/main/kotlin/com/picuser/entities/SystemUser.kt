package com.picuser.entities

import org.springframework.data.annotation.Id
import org.springframework.data.elasticsearch.annotations.Document
import org.springframework.data.elasticsearch.annotations.Setting

@Document(indexName = "system_users", type = "SystemUser")
@Setting(settingPath = "settings.json")
data class SystemUser (

    @Id var id: String? = null,

    var email: String? = null,

    var name: String? = null
)