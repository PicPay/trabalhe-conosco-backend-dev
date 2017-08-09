package models.enums;

/**
 *Classe enumerada para definir prioridade do usuario
 * 
 * @author gustavo
 * @since 08/08/2017
 */
public enum Priority {
    HIGHER (1), LOWER (2);

    public int value;
    
    Priority(int value){
        this.value = value;
    }
}
