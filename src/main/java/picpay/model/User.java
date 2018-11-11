package picpay.model;

import java.util.UUID;

import com.fasterxml.jackson.annotation.JsonIgnore;

public class User {
	@Override
	public String toString() {
		return "User [uuid=" + uuid + ", login=" + login + ", name=" + name + ", priority=" + priority + "]";
	}

	private UUID uuid;
	private String login;
	private String name;
	private int priority;
	
	public User(UUID uuid, String login, String name)
	{
		this.uuid = uuid;
		this.login = login;
		this.name = name;
		this.setPriority(10);
	}
	
	public User()
	{
	}
	
	public UUID getUuid() {
		return uuid;
	}
	public void setUuid(UUID uuid) {
		this.uuid = uuid;
	}
	public String getUsername() {
		return login;
	}
	public void setUsername(String username) {
		this.login = username;
	}
	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}

	@JsonIgnore
	public int getPriority() {
		return priority;
	}

	public void setPriority(int priority) {
		this.priority = priority;
	}

}
