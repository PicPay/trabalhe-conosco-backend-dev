package com.picpay;


import org.apache.tomcat.util.http.fileupload.IOUtils;
import org.h2.jdbcx.JdbcDataSource;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;

import javax.sql.DataSource;
import java.io.File;
import java.io.InputStream;
import java.net.URL;
import java.nio.file.Paths;
import java.nio.file.StandardCopyOption;
import java.util.zip.GZIPInputStream;


@Configuration
public class DatasourceConfig {

    @Value("${com.picpay.csv.database.url}")
    private final String csvDatabaseUrl = null;

    private static final Logger LOG =
            LoggerFactory.getLogger(DatasourceConfig.class);

    private static final String CSV_PATH = "src/main/resources/users.csv";

    @Bean(name = "mainDataSource")
    public DataSource createMainDataSource() throws Exception {
        LOG.info("Importing and extracting CSV file...");

        if (!java.nio.file.Files.exists(Paths.get(CSV_PATH))) {

            InputStream zipFileInputStream = new URL(csvDatabaseUrl).openStream();
            GZIPInputStream is = new GZIPInputStream(zipFileInputStream);

            File targetFile = new File(CSV_PATH);

            java.nio.file.Files.copy(
                    is,
                    targetFile.toPath(),
                    StandardCopyOption.REPLACE_EXISTING);

            IOUtils.closeQuietly(is);
            LOG.info("CSV imported and extracted...");
        }

        JdbcDataSource ds = new JdbcDataSource();
        ds.setURL("jdbc:h2:file:~/testdb;LOG=0;CACHE_SIZE=65536;LOCK_MODE=0;UNDO_LOG=0");
        ds.setUser("sa");
        ds.setPassword("");
        return ds;
    }
}