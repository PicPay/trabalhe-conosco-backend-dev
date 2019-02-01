package com.picuser.configuration

import com.picuser.entities.User
import org.elasticsearch.client.Client
import org.elasticsearch.common.settings.Settings
import org.elasticsearch.common.transport.TransportAddress
import org.springframework.context.annotation.Bean
import org.springframework.context.annotation.Configuration
import org.springframework.context.annotation.PropertySource
import org.springframework.core.env.Environment
import org.springframework.data.elasticsearch.core.ElasticsearchOperations
import org.springframework.data.elasticsearch.core.ElasticsearchTemplate
import org.springframework.data.elasticsearch.repository.config.EnableElasticsearchRepositories
import javax.annotation.Resource
import java.net.InetAddress
import org.elasticsearch.transport.client.PreBuiltTransportClient

@Configuration
@PropertySource("classpath:/application.properties")
@EnableElasticsearchRepositories(basePackages = ["com.picuser.repository"])
class ElasticSearchConfiguration {

    @Resource
    private val environment: Environment? = null

    @Bean
    fun client(): Client {
        val settings = Settings.builder().put("client.transport.sniff", false).build()
        val client = PreBuiltTransportClient(settings)
        val hostName = InetAddress.getByName(environment!!.getProperty("elasticsearch.host"))
        val portNumber = Integer.parseInt(environment.getProperty("elasticsearch.port"))
        client.addTransportAddress(TransportAddress(hostName, portNumber))
        return client
    }

    @Bean
    fun elasticsearch(): ElasticsearchOperations {
        val op = ElasticsearchTemplate(client())
        op.putMapping(User::class.java)
        return op
    }
}