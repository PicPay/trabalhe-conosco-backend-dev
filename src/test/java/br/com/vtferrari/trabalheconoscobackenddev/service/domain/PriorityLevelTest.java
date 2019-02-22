package br.com.vtferrari.trabalheconoscobackenddev.service.domain;

import org.junit.Test;

import static org.junit.Assert.assertEquals;

public class PriorityLevelTest {

    @Test
    public void testShouldGetHighPriority() {
        assertEquals(PriorityLevel.HIGH, PriorityLevel.fromLevel(0));
    }

    @Test
    public void testShouldGetLowPriority() {
        assertEquals(PriorityLevel.LOW, PriorityLevel.fromLevel(1));
    }

    @Test
    public void testShouldGetERRORPriority() {
        assertEquals(PriorityLevel.ERROR, PriorityLevel.fromLevel(5461235));
    }

}