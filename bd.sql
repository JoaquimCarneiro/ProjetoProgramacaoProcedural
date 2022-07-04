DROP TABLE IF EXISTS users;
CREATE TABLE users (
    usersId int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    usersEmail varchar(128) NOT NULL,
    usersUid varchar(128) NOT NULL,
    usersPwd varchar(128) NOT NULL,
    userlevel int(11) NOT NULL,
);

-- tabela para os níveis de utilizador
DROP TABLE IF EXISTS user_level;
CREATE TABLE user_level(
    userlevel int(11) PRIMARY KEY NOT NULL,
    levelname varchar(128),
    discription varchar(128)
);

-- Tokens
DROP TABLE IF EXISTS tokens;
CREATE TABLE tokens(
    tokenId int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    email varchar(128) NOT NULL,
    tokenSelector TEXT NOT NULL,
    token LONGTEXT NOT NULL,
    expires TEXT NOT NULL,
    type varchar(128) NOT NULL
);

-- ligação de tabelas
ALTER TABLE users
    ADD CONSTRAINT userlevel_users FOREIGN KEY (userlevel) REFERENCES user_level (userlevel);

-- Inserir valores defeito
INSERT INTO user_level
    (userlevel, levelname, discription)
VALUES
    (0, "convidado", "Nível inicial - convidado não registado"),
    (1, "registado", "Utilizador registado não confirmado"),
    (2, "verificado", "Utilizador registado e confirmado"),
    (9, "administrador", "Nível de administrador máximo");