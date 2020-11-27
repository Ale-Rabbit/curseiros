CREATE DATABASE curseiros;

CREATE TABLE tb_usuario(
	usuario_pk INTEGER NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(20) NOT NULL,
    senha VARCHAR(20) NOT NULL
);

CREATE TABLE tb_curso(
	curso_pk INTEGER NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(20) NOT NULL,
    descricao VARCHAR(200),
    imagem MEDIUMBLOB
);


CREATE TABLE tb_curso_usuario(
	curso_usuario_pk INTEGER NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
    fk_usuario INTEGER NOT NULL,
    fk_curso INTEGER NOT NULL,
    FOREIGN KEY (fk_usuario) REFERENCES tb_usuario(usuario_pk),
    FOREIGN KEY (fk_curso) REFERENCES tb_curso(curso_pk)
);

COMMIT;