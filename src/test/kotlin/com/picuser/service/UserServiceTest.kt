package com.picuser.service

import com.picuser.service.configuration.ElasticSearchConfiguration
import com.picuser.service.entities.User
import com.picuser.service.service.UserService
import org.junit.Test
import org.junit.runner.RunWith
import org.springframework.beans.factory.annotation.Autowired
import org.springframework.boot.test.context.SpringBootTest
import org.springframework.test.context.junit4.SpringRunner
import org.junit.Assert.*
import org.springframework.data.domain.PageRequest

@RunWith(SpringRunner::class)
@SpringBootTest(classes = [Application::class])
class UserServiceTest {

    @Autowired
    private val userService: UserService? = null

    @Autowired
    private val esConfig: ElasticSearchConfiguration? = null

    @Test
    fun testSave() {

        val user = User("1", "joao.da.silva", "João da Silva", 0)
        val testUser = userService!!.save(user)

        assertNotNull(testUser.id)
        assertEquals(testUser.userName, user.userName)
        assertEquals(testUser.name, user.name)
        assertEquals(testUser.priority, user.priority)
    }

    @Test
    fun testSaveAll() {

        val user1 = User("1", "joao.da.silva", "João da Silva", 0)
        val user2 = User("2", "maria.da.silva", "Maria da Silva", 1)
        val user3 = User("3", "roberto.pinheiro", "Roberto Pinheiro", 2)
        val users = listOf(user1, user2, user3)
        val testUsers = userService!!.saveAll(users)

        testUsers.forEachIndexed {idx, testUser ->
            assertNotNull(testUser.id)
            assertEquals(testUser.userName, users[idx].userName)
            assertEquals(testUser.name, users[idx].name)
            assertEquals(testUser.priority, users[idx].priority)
        }
    }

    @Test
    fun testFindOne() {

        val user = User("1", "joao.da.silva", "João da Silva", 0)
        userService!!.save(user)

        val testUser = userService.findOne(user.id ?: "")

        assertNotNull(testUser.id)
        assertEquals(testUser.userName, user.userName)
        assertEquals(testUser.name, user.name)
        assertEquals(testUser.priority, user.priority)
    }

    @Test
    fun testFindByName() {

        val user = User("1", "joao.da.silva", "João da Silva", 0)
        userService!!.save(user)

        val userByName = userService.findUser(user.name ?: "", PageRequest.of(0, 1))
        assertEquals(userByName.size, 1)
    }

}