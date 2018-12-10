package db.migration;

import java.io.File;
import java.io.IOException;
import java.nio.file.Files;
import java.util.stream.Stream;
import org.flywaydb.core.api.migration.BaseJavaMigration;
import org.flywaydb.core.api.migration.Context;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.datasource.SingleConnectionDataSource;


public class V002__Create_priorities extends BaseJavaMigration {

  public void migrate(Context context) {
    JdbcTemplate template =
        new JdbcTemplate(new SingleConnectionDataSource(context.getConnection(), true));

    template.execute(
        "CREATE TABLE priority1 (id VARCHAR(128) PRIMARY KEY) ENGINE=InnoDB DEFAULT CHARSET=utf8");

    template.execute(
        "CREATE TABLE priority2 (id VARCHAR(128) PRIMARY KEY) ENGINE=InnoDB DEFAULT CHARSET=utf8");

    ClassLoader classLoader = getClass().getClassLoader();
    File lista_relevancia_1 =
        new File(classLoader.getResource("db/initial-data/lista_relevancia_1.txt").getFile());
    try (Stream<String> stream = Files.lines(lista_relevancia_1.toPath())) {
      stream.forEach(str -> {
        template.update("INSERT INTO priority1 (id) VALUES ('" + str + "')");
      });
    } catch (IOException e) {
      e.printStackTrace();
    }

    File lista_relevancia_2 =
        new File(classLoader.getResource("db/initial-data/lista_relevancia_2.txt").getFile());
    try (Stream<String> stream = Files.lines(lista_relevancia_2.toPath())) {
      stream.forEach(str -> {
        template.update("INSERT INTO priority2 (id) VALUES ('" + str + "')");
      });
    } catch (IOException e) {
      e.printStackTrace();
    }
  }

}
