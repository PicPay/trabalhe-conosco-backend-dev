package picpay.model;

import java.util.UUID;

import org.springframework.data.annotation.Id;
import org.springframework.data.elasticsearch.annotations.Document;


@Document(indexName = "users", type = "user")
public class User {
	@Override
	public String toString() {
		return "User [uuid=" + uuid + ", login=" + login + ", name=" + name + ", priority=" + priority + "]";
	}

	@Id
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
	public String getLogin() {
		return login;
	}
	public void setLogin(String login) {
		this.login = login;
	}
	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}

	//@JsonIgnore
	public int getPriority() {
		return priority;
	}

	public void setPriority(int priority) {
		this.priority = priority;
	}

}
