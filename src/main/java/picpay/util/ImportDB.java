package picpay.util;

import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;

public class ImportDB {
	public static String formatLocalDateTime2DbStyle(LocalDateTime localDateTime) {
		return DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss").format(localDateTime);
	}
}