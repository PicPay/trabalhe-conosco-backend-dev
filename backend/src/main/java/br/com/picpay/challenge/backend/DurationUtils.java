package br.com.picpay.challenge.backend;

import java.time.Duration;
import java.util.StringJoiner;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class DurationUtils {

	private static final Pattern PATTERN_EXTRACT_DURATION = Pattern.compile("(.*h)?(.*m)?(.*s)?");
	
	/**
	 * Apresentação amigável de um objeto {@link Duration}.
	 * 
	 * @param duration Objeto a ser apresentado
	 * @return
	 */
	public static String toString(Duration duration) {
		String durationLower = duration.toString().substring(2).toLowerCase();
		Matcher matcher = PATTERN_EXTRACT_DURATION.matcher(durationLower);
		StringJoiner joiner = new StringJoiner(" ");
		if (matcher.find()) {
			for (int g = 1; g <= matcher.groupCount(); g++) {
				String groupValue = matcher.group(g);
				if (groupValue != null) {
					joiner.add(groupValue);
				}
			}
		}
		return joiner.toString();
	}
	
}
