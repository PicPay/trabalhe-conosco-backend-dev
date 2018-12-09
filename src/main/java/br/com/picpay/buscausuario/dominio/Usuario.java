package br.com.picpay.buscausuario.dominio;

import java.util.Set;
import java.util.UUID;

import org.springframework.data.annotation.Id;
import org.springframework.data.mongodb.core.mapping.Document;

import lombok.AllArgsConstructor;
import lombok.EqualsAndHashCode;
import lombok.Getter;
import lombok.ToString;

@Document(collection="usuarios")
@AllArgsConstructor
@EqualsAndHashCode
@ToString
@Getter
public class Usuario {

	@Id
	private UUID id;
	
	private String nome;
	
	private String username;
	
	protected Usuario() {}

	public boolean possuiUmDessesIds(Set<UUID> uuidsPrioritarios) {
		return uuidsPrioritarios == null ? false : uuidsPrioritarios.contains(id);
	}
}
