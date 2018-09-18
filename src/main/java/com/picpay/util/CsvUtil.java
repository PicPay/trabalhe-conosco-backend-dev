package com.picpay.util;

import com.fasterxml.jackson.databind.MappingIterator;
import com.fasterxml.jackson.databind.ObjectReader;
import com.fasterxml.jackson.dataformat.csv.CsvMapper;
import com.fasterxml.jackson.dataformat.csv.CsvSchema;

import java.io.IOException;
import java.io.InputStream;

public class CsvUtil {

    public static <T> MappingIterator<T> read(Class<T> clazz, InputStream stream) throws IOException {
        final CsvMapper mapper = new CsvMapper();
        CsvSchema schema = mapper.schemaFor(clazz).withColumnReordering(true);
        ObjectReader reader = mapper.readerFor(clazz).with(schema);
        return reader.readValues(stream);
    }
}