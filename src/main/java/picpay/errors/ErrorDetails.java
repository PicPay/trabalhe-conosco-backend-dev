package picpay.errors;

public class ErrorDetails {
	private String title;
	private int status;
	protected Object detail;
	private long timestamp;
	private String developerMessage;
	
	public ErrorDetails(String title, int status, Object detail, long timestamp, String developerMessage) {
		super();
		this.title = title;
		this.status = status;
		this.detail = detail;
		this.timestamp = timestamp;
		this.developerMessage = developerMessage;
	}

	public String getTitle() {
		return title;
	}

	public int getStatus() {
		return status;
	}

	public Object getDetail() {
		return detail;
	}

	public long getTimestamp() {
		return timestamp;
	}

	public String getDeveloperMessage() {
		return developerMessage;
	}
}
