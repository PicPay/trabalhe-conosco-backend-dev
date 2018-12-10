package db.migration;

import org.flywaydb.core.api.migration.BaseJavaMigration;
import org.flywaydb.core.api.migration.Context;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.datasource.SingleConnectionDataSource;


public class V001__Create_table_users extends BaseJavaMigration {

  public void migrate(Context context) {
    JdbcTemplate template =
        new JdbcTemplate(new SingleConnectionDataSource(context.getConnection(), true));

    template.execute("CREATE TABLE IF NOT EXISTS users ("
        + " id          VARCHAR(64) PRIMARY KEY,"
        + " name        VARCHAR(64),"
        + " username    VARCHAR(32),"
        + " priority    TINYINT"
        + ") ENGINE=MyISAM DEFAULT CHARSET=utf8");

    template.execute("set unique_checks=0");
    template.execute("set foreign_key_checks=0");
    template.execute("set sql_log_bin=0");
	template.execute("set global local_infile='ON'");
	
	template.execute("GRANT FILE ON *.* TO 'root'@'localhost';");

    //template.execute("load data local infile '/users.csv'"
	template.execute("load data infile '/tmp/users.csv'"
        + " into table picpay_example.users"
        + " fields terminated by ','"
        + " enclosed by '\"'"
        + " lines terminated by '\r\n'"
        + " (id,name,username)");

    template.execute("ALTER TABLE users ADD FULLTEXT full_text(name,username)");

    template.execute("set unique_checks=1");
    template.execute("set foreign_key_checks=1");
    template.execute("set sql_log_bin=1");

  }

}
