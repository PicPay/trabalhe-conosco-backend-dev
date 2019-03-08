package com.example.picpay.api.dialect;

import org.hibernate.dialect.MySQL5Dialect;
import org.hibernate.dialect.function.SQLFunctionTemplate;
import org.hibernate.type.StandardBasicTypes;

public class MySQL5DialectCustom extends MySQL5Dialect {

  public MySQL5DialectCustom() {
    super();
    registerFunction("match", new SQLFunctionTemplate(StandardBasicTypes.BOOLEAN,
        " match(?1, ?2) against (?3 in boolean mode) "));
  }

}
