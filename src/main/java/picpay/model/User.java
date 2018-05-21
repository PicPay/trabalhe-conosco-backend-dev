package picpay.model;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.FetchType;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.OneToOne;

import com.fasterxml.jackson.annotation.JsonIgnore;

@Entity(name = "user")
public class User {
	@Id
	@Column(length=36)
	private String id;
	@Column(length=200)
	private String name;
	@Column(length=100)
	private String username;

	@OneToOne(fetch = FetchType.LAZY, optional = true)
	@JoinColumn(name = "id", nullable = true)
	@JsonIgnore
	private Prior1 prior1;
	@OneToOne(fetch = FetchType.LAZY, optional = true)
	@JoinColumn(name = "id", nullable = true)
	@JsonIgnore
	private Prior2 prior2;

	public String getId() {
		return id;
	}

	public void setId(String id) {
		this.id = id;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getUsername() {
		return username;
	}

	public void setUsername(String username) {
		this.username = username;
	}

	public Prior1 getPrior1() {
		return prior1;
	}

	public void setPrior1(Prior1 prior1) {
		this.prior1 = prior1;
	}

	public Prior2 getPrior2() {
		return prior2;
	}

	public void setPrior2(Prior2 prior2) {
		this.prior2 = prior2;
	}

	@Override
	public int hashCode() {
		final int prime = 31;
		int result = 1;
		result = prime * result + ((id == null) ? 0 : id.hashCode());
		return result;
	}

	@Override
	public boolean equals(Object obj) {
		if (this == obj)
			return true;
		if (obj == null)
			return false;
		if (getClass() != obj.getClass())
			return false;
		User other = (User) obj;
		if (id == null) {
			if (other.id != null)
				return false;
		} else if (!id.equals(other.id))
			return false;
		return true;
	}
}
