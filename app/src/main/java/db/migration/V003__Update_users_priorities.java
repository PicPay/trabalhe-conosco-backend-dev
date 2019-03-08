package db.migration;

import org.flywaydb.core.api.migration.BaseJavaMigration;
import org.flywaydb.core.api.migration.Context;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.datasource.SingleConnectionDataSource;


public class V003__Update_users_priorities extends BaseJavaMigration {

  public void migrate(Context context) {
    JdbcTemplate template =
        new JdbcTemplate(new SingleConnectionDataSource(context.getConnection(), true));

    template.update(
        "UPDATE users AS u"
        + " INNER JOIN priority1 AS p ON u.id = p.id"
        + " SET u.priority = 1");

    template.update(
        "UPDATE users AS u"
        + " INNER JOIN priority2 AS p ON u.id = p.id"
        + " SET u.priority = 2");

    template.execute("CREATE INDEX index_users_priority ON users (priority)");
  }

}
