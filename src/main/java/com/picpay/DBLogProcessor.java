package com.picpay;

import com.picpay.model.User;
import org.springframework.batch.item.ItemProcessor;

public class DBLogProcessor implements ItemProcessor<User, User>
{
    public User process(User user) throws Exception
    {
        System.out.println("Inserting user : " + user);
        return user;
    }
}