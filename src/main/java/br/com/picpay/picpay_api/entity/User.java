package br.com.picpay.picpay_api.entity;

import java.time.LocalDateTime;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import javax.persistence.PrePersist;
import javax.persistence.PreUpdate;
import javax.persistence.SequenceGenerator;
import javax.persistence.Table;

import com.fasterxml.jackson.annotation.JsonProperty;

import lombok.Builder;
import lombok.Data;

@Data
@Builder
@Entity
@Table(name = "users")
public class User {
	@Id
	@SequenceGenerator(name = "user_id_seq", sequenceName = "user_id_seq", initialValue = 1, allocationSize = 1)
	@GeneratedValue(generator = "user_id_seq")
	private Long id;

	@Column(nullable = false)
	private String hash;
	
	@Column(nullable = false)
	private String name;
	
	@Column(nullable = false)
	private String username;
	
	@JsonProperty("created_at")
	private LocalDateTime createdAt;
	
	@JsonProperty("updated_at")
	private LocalDateTime updatedAt;
	
	@PrePersist
	void preSave() {
		if (createdAt == null) {
			createdAt = LocalDateTime.now();
		}
	}

	@PreUpdate
	void preUpdate() {
		if (updatedAt == null) {
			updatedAt = LocalDateTime.now();
		}
	}
	
	public User() {
		
	}
	
	public User(Long id, String hash, String name, String username, LocalDateTime createdAt, LocalDateTime updatedAt) {
		super();
		this.id = id;
		this.hash = hash;
		this.name = name;
		this.username = username;
		this.createdAt = createdAt;
		this.updatedAt = updatedAt;
	}
}