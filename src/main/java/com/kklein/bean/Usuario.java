package com.kklein.bean;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Table;

@Entity
@Table(name="usuario")
public class Usuario extends AbstractJpaBean  {

	@Id
	@Column(name = "usu_cd_usuario")
	@GeneratedValue(strategy = GenerationType.IDENTITY)
	private long usuCdUsuario;
	
	@Column(name = "usu_ds_codigo")
	private String usuDsCodigo;
	
	@Column(name = "usu_ds_login")
	private String usuDsLogin;

	@Column(name = "usu_nm_usuario")
	private String usuNmUsuario;
	
	@Column(name = "usu_fl_lista_prioridade")
	private int usuFlListaPrioridade;
	
	public Usuario() {

	}	
	
	public Usuario(long usuCdUsuario, String usuDsCodigo, String usuDsLogin, String usuNmUsuario, int usuFlListaPrioridade) {
		super();
		this.usuCdUsuario = usuCdUsuario;
		this.usuDsCodigo = usuDsCodigo;
		this.usuDsLogin = usuDsLogin;
		this.usuNmUsuario = usuNmUsuario;
		this.usuFlListaPrioridade = usuFlListaPrioridade;
	}

	public long getUsuCdUsuario() {
		return usuCdUsuario;
	}

	public void setUsuCdUsuario(long usuCdUsuario) {
		this.usuCdUsuario = usuCdUsuario;
	}

	public String getUsuDsCodigo() {
		return usuDsCodigo;
	}

	public void setUsuDsCodigo(String usuDsCodigo) {
		this.usuDsCodigo = usuDsCodigo;
	}

	public String getUsuDsLogin() {
		return usuDsLogin;
	}

	public void setUsuDsLogin(String usuDsLogin) {
		this.usuDsLogin = usuDsLogin;
	}

	public String getUsuNmUsuario() {
		return usuNmUsuario;
	}

	public void setUsuNmUsuario(String usuNmUsuario) {
		this.usuNmUsuario = usuNmUsuario;
	}

	public int getUsuFlListaPrioridade() {
		return usuFlListaPrioridade;
	}

	public void setUsuFlListaPrioridade(int usuFlListaPrioridade) {
		this.usuFlListaPrioridade = usuFlListaPrioridade;
	}
	


}
