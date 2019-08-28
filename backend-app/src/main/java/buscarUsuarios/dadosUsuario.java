package buscarUsuarios;

public class dadosUsuario {
    private String id;
    private String nome;
    private String username;

    public dadosUsuario(String id, String nome, String username) {
        this.id = id;
        this.nome = nome;
        this.username = username;
    }

    public String getId() {
        return id;
    }

    public String getNome() {
        return nome;
    }
    
    public String getUsername() {
        return username;
    }
    
    public void setId(String id) {
        this.id = id;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }
    
    public void setUsername(String username) {
        this.username = username;
    }
}
