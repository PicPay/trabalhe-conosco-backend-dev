/* Used by UserControllerAcceptanceTest */

CREATE TABLE IF NOT EXISTS user (
  id VARCHAR(36) NOT NULL,
  name VARCHAR(64) NOT NULL,
  username VARCHAR(64) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS first_user (
  id VARCHAR(36) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS second_user (
  id VARCHAR(36) NOT NULL,
  PRIMARY KEY (id)
);