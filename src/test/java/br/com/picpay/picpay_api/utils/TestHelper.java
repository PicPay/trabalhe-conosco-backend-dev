package br.com.picpay.picpay_api.utils;

import br.com.picpay.picpay_api.entity.User;

import java.util.Random;
import java.util.UUID;

import static java.lang.String.format;

public class TestHelper {
    public static User buildUser() {
        String uuid = UUID.randomUUID().toString();
        return User.builder()
                .name("name-"+uuid)
                .hash("10bd915d-ee8f-4694-a76a-c20004ad698d")
                .username(format("user-%s", uuid))
                .build();
    }

    public static User buildUserWithId() {
        Random random = new Random();
        String uuid = UUID.randomUUID().toString();
        return User.builder()
                .id(random.nextLong())
                .name("name-"+uuid)
                .hash("4ca90131-a203-40f4-bc6e-821ded6def5a")
                .username(format("user-%s", uuid))
                .build();
    }
}
