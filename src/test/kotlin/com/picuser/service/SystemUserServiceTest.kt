package com.picuser.service

import com.picuser.service.configuration.ElasticSearchConfiguration
import com.picuser.service.entities.SystemUser
import com.picuser.service.service.SystemUserService
import org.junit.Test
import org.junit.runner.RunWith
import org.springframework.beans.factory.annotation.Autowired
import org.springframework.boot.test.context.SpringBootTest
import org.springframework.test.context.junit4.SpringRunner
import org.junit.Assert.*
import org.springframework.data.domain.PageRequest

@RunWith(SpringRunner::class)
@SpringBootTest(classes = [Application::class])
class SystemUserServiceTest {

    @Autowired
    private val sysUserService: SystemUserService? = null

    @Autowired
    private val esConfig: ElasticSearchConfiguration? = null

    @Test
    fun testSaveAll() {

        val user1 = SystemUser("1", "joao.da.silva@gmail.com", "João da Silva")
        val user2 = SystemUser("2", "maria.da.silva@gmail.com", "Maria da Silva")
        val user3 = SystemUser("3", "roberto.pinheiro@gmail.com", "Roberto Pinheiro")
        val users = listOf(user1, user2, user3)
        val testUsers = sysUserService!!.saveAll(users)

        testUsers.forEachIndexed {idx, testUser ->
            assertNotNull(testUser.id)
            assertEquals(testUser.email, users[idx].email)
            assertEquals(testUser.name, users[idx].name)
        }
    }

    @Test
    fun testFindByEmail() {

        val user = SystemUser("1", "joao.da.silva@gmail.com", "João da Silva")
        sysUserService!!.saveAll(listOf(user))

        val userByName = sysUserService.findSystemUser(user.email ?: "", PageRequest.of(0, 1))
        assertEquals(userByName.size, 1)
    }

}