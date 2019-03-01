package br.com.vtferrari.trabalheconoscobackenddev.repository.converter;

import br.com.vtferrari.trabalheconoscobackenddev.repository.model.UserElasticsearch;
import br.com.vtferrari.trabalheconoscobackenddev.service.domain.User;
import org.junit.Before;
import org.junit.Test;

import static org.junit.Assert.*;

public class UserConverterTest {

    private UserConverter userConverter;

    @Before
    public void setup(){
        userConverter = new UserConverter();
    }

    @Test
    public void testShouldConvert(){
        final UserElasticsearch spec = new UserElasticsearch();
        spec.setPriority(1);
        spec.setId("new id");
        spec.setName("test");
        spec.setUsername("test");

        final User result = userConverter.convert(spec);

        assertEquals(spec.getId(),result.getId());
        assertEquals(spec.getName(),result.getName());
        assertEquals(spec.getUsername(),result.getUsername());
    }

}