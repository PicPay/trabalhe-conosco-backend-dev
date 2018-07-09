package br.com.picpay.challenge.backend.importacao;

import java.util.Date;

import org.springframework.data.annotation.Id;
import org.springframework.data.mongodb.core.mapping.Document;

@Document(collection = "logs.importacao")
public class LogImportacao {

	@Id
	private String id;
	private Date date;
	private boolean current;
	private StatusImportacao status;
	private String descricaoStatus;
	private Date lastUpdate;
	private String fileUrl;
	private long fileSize;
	private String fileHashSha2;
	private String elapsedTime;

	public String getId() {
		return id;
	}

	public void setId(String id) {
		this.id = id;
	}

	public Date getDate() {
		return date;
	}
	
	public void setDate(Date date) {
		this.date = date;
	}

	public boolean isCurrent() {
		return current;
	}

	public void setCurrent(boolean current) {
		this.current = current;
	}

	public StatusImportacao getStatus() {
		return status;
	}

	public void setStatus(StatusImportacao status) {
		this.status = status;
	}
	
	public String getDescricaoStatus() {
		return descricaoStatus;
	}
	
	public void setDescricaoStatus(String descricaoStatus) {
		this.descricaoStatus = descricaoStatus;
	}

	public Date getLastUpdate() {
		return lastUpdate;
	}
	
	public void setLastUpdate(Date lastUpdate) {
		this.lastUpdate = lastUpdate;
	}
	
	public String getFileUrl() {
		return fileUrl;
	}
	
	public void setFileUrl(String fileUrl) {
		this.fileUrl = fileUrl;
	}

	public long getFileSize() {
		return fileSize;
	}

	public void setFileSize(long fileSize) {
		this.fileSize = fileSize;
	}
	
	public String getFileHashSha2() {
		return fileHashSha2;
	}
	
	public void setFileHashSha2(String fileHashSha2) {
		this.fileHashSha2 = fileHashSha2;
	}

	public String getElapsedTime() {
		return elapsedTime;
	}

	public void setElapsedTime(String elapsedTime) {
		this.elapsedTime = elapsedTime;
	}

}
