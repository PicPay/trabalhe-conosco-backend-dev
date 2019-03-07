package com.tardelli.server.service;

import com.opencsv.bean.CsvToBean;
import com.opencsv.bean.CsvToBeanBuilder;
import com.tardelli.server.dao.UserElasticRepository;
import com.tardelli.server.model.EnumRelevancy;
import com.tardelli.server.model.User;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.io.IOException;
import java.io.Reader;
import java.net.URISyntaxException;
import java.net.URL;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.HashSet;
import java.util.Objects;
import java.util.Set;
import java.util.stream.Collectors;
import java.util.stream.Stream;

@Service
public class UserService {

    private static final String SAMPLE_CSV_FILE_PATH = "database/users.csv";
    private static final String SAMPLE_HIGH_RELEVANCE_FILE_PATH = "database/lista_relevancia_1.txt";
    private static final String SAMPLE_AVERAGE_RELEVANCE_FILE_PATH = "database/lista_relevancia_2.txt";

    @Autowired
    private UserElasticRepository userElasticRepository;

    private Set<String> listHighRelevance = new HashSet<>();
    private Set<String> listAverageRelevance = new HashSet<>();

    public void loadCsv() {
        try {
            CsvToBean<User> csvToBean = loadCsvUsers();
            loadListHighRelevance();
            loadListAverageRelevance();
            saveUsers(csvToBean);
        } catch (IOException | URISyntaxException e) {
            e.printStackTrace();
        }
    }

    private void saveUsers(CsvToBean<User> csvToBean) {
        csvToBean.forEach(user -> {
                    setRelevancy(user);
                    userElasticRepository.save(user);
                }
        );
    }

    private void setRelevancy(User user) {
        user.setRelevancy(EnumRelevancy.LOW_RELEVANCE.getValue());

        if (listAverageRelevance.contains(user.getId())) {
            user.setRelevancy(EnumRelevancy.AVERAGE_RELEVANCE.getValue());
        }

        if (listHighRelevance.contains(user.getId())) {
            user.setRelevancy(EnumRelevancy.HIGH_RELEVANCE.getValue());
        }
    }

    private Set<String> loadListHighRelevance() throws URISyntaxException, IOException {
        Stream<String> lines = Files.lines(Paths.get(Objects.requireNonNull(getClass().getClassLoader().getResource(SAMPLE_HIGH_RELEVANCE_FILE_PATH)).getPath()));

        listHighRelevance = lines.collect(Collectors.toCollection(HashSet::new));

        return listHighRelevance;
    }

    private Set<String> loadListAverageRelevance() throws URISyntaxException, IOException {
        Stream<String> lines = Files.lines(Paths.get(Objects.requireNonNull(getClass().getClassLoader().getResource(SAMPLE_AVERAGE_RELEVANCE_FILE_PATH)).getPath()));

        listAverageRelevance = lines.collect(Collectors.toCollection(HashSet::new));

        return listAverageRelevance;
    }

    private CsvToBean<User> loadCsvUsers() throws IOException, URISyntaxException {

        Reader reader = Files.newBufferedReader(Paths.get(Objects.requireNonNull(getClass().getClassLoader().getResource(SAMPLE_CSV_FILE_PATH)).getPath()));
        return (CsvToBean<User>) new CsvToBeanBuilder(reader)
                .withType(User.class)
                .withIgnoreLeadingWhiteSpace(true)
                .build();
    }
}