package br.com.picpay.picpay_api.entity;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.SequenceGenerator;
import javax.persistence.Table;

import lombok.Builder;
import lombok.Data;

@Data
@Builder
@Entity
@Table(name = "relevancia")
public class Relevancia {
	@Id
	@SequenceGenerator(name = "relevancia_id_generator", sequenceName = "relevancia_id_seq")
	@GeneratedValue(generator = "relevancia_id_generator")
	private Long id;
	@Column(nullable = false)
	private Integer precedencia;
	@Column(nullable = false)
	private String hash;

	public Relevancia() {

	}

	public Relevancia(Long id, Integer precedencia, String hash) {
		super();
		this.id = id;
		this.precedencia = precedencia;
		this.hash = hash;
	}
}