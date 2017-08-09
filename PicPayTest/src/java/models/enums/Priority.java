/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package models.enums;

/**
 * Enum para definir prioridade de exibicao
 *
 * @author gustavo
 * @since 09/08/2017
 */
public enum Priority {
    High(1), LOW(2), NONE(3);

    public int value;

    /**
     * Construtor da classe
     *
     * @param value valor da prioridade
     * @author gustavo
     * @since 09/08/2017
     */
    private Priority(int value) {
        this.value = value;
    }

}
