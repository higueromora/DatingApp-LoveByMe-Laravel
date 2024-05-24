CREATE DATABASE IF NOT EXISTS laravel_master;
USE laravel_master;

CREATE TABLE users(
id              int (255) auto_increment not null,
role            varchar (20),
name            varchar (100),
surname         varchar (200),
nick            varchar (100),
telefono        int (255),
genero          varchar (100),
edad        int (3),
residencia           varchar (255),
profileDescription	varchar(255),	
email           varchar (255),
password        varchar (255),
image           varchar (255),
created_at      datetime,
updated_at      datetime,
remember_token  varchar (255),
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

-- para tener la imagen por defecto de avatar, poner de la marcar logotipo
ALTER TABLE users 
MODIFY image varchar(255) DEFAULT 'default.jpg';

CREATE TABLE likematch(
id              int(255) auto_increment not null,
user_id         int(255),
target_user_id  int(255),
click_type      varchar(20),
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_likeMatch PRIMARY KEY(id),
CONSTRAINT fk_user_id FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_target_user_id FOREIGN KEY(target_user_id) REFERENCES users(id)
)ENGINE=InnoDB;

CREATE TABLE usermatch(
id              int(255) auto_increment not null,
user1_id        int(255),
user2_id        int(255),
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_matches PRIMARY KEY(id),
CONSTRAINT fk_user1_id FOREIGN KEY(user1_id) REFERENCES users(id),
CONSTRAINT fk_user2_id FOREIGN KEY(user2_id) REFERENCES users(id)
)ENGINE=InnoDB;


CREATE TABLE messages(
    id INT(255) AUTO_INCREMENT NOT NULL,
    sender_id INT(255),
    receiver_id INT(255),
    content TEXT,
    read_at DATETIME DEFAULT NULL,
    created_at DATETIME,
    updated_at DATETIME,
    CONSTRAINT pk_messages PRIMARY KEY(id),
    CONSTRAINT fk_sender_id FOREIGN KEY(sender_id) REFERENCES users(id),
    CONSTRAINT fk_receiver_id FOREIGN KEY(receiver_id) REFERENCES users(id)
)ENGINE=InnoDB;


CREATE TABLE user_blocks(
    id INT(255) AUTO_INCREMENT NOT NULL,
    blocker_id INT(255),
    blocked_id INT(255),
    created_at DATETIME,
    updated_at DATETIME,
    CONSTRAINT pk_user_blocks PRIMARY KEY(id),
    CONSTRAINT fk_blocker_id FOREIGN KEY(blocker_id) REFERENCES users(id),
    CONSTRAINT fk_blocked_id FOREIGN KEY(blocked_id) REFERENCES users(id)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS images(
id              int (255) auto_increment not null,
user_id         int (255),
image_path      varchar (255),
description     text,
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_images PRIMARY KEY(id),
CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS comments(
id              int (255) auto_increment not null,
user_id         int (255),
image_id        int (255),
content         text,
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_comments PRIMARY KEY(id),
CONSTRAINT fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
CONsTRAINT fk_comments_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;


CREATE TABLE IF NOT EXISTS likes(
id              int (255) auto_increment not null,
user_id         int (255),
image_id        int (255),
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_likes PRIMARY KEY(id),
CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
CONsTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;

-- Las 2 tablas creadas con comando php artisan ui vue --auth
-- Crear la tabla password_reset_tokens
CREATE TABLE password_reset_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255),
    token VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (email) REFERENCES users(email)
);

-- Crear la tabla personal_access_tokens
CREATE TABLE personal_access_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    token VARCHAR(255),
    name VARCHAR(255),
    tokenable_id INT,
    tokenable_type VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tokenable_id) REFERENCES users(id)
);



INSERT INTO likes VALUES(NULL, 1, 4, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 2, 4, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 3, 1, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 3, 2, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 2, 1, CURTIME(), CURTIME());



INSERT INTO comments VALUES(NULL, 1, 4, 'Chocolate con muy buena pinta', CURTIME(),CURTIME());
INSERT INTO comments VALUES(NULL, 2, 1, 'De las mejores hamburguesas que he visto', CURTIME(),CURTIME());
INSERT INTO comments VALUES(NULL, 2, 4, 'Que rico', CURTIME(),CURTIME());


INSERT INTO images VALUES(NULL, 1, 'test.jpg','descripción de prueba 1', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 1, 'hamburguesa.jpg','descripción de prueba 1', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 1, 'pizza.jpg','descripción de prueba 1', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 3, 'chocolate.jpg','descripción de prueba 1', CURTIME(), CURTIME());

INSERT INTO usermatch (user1_id, user2_id, created_at, updated_at)
SELECT DISTINCT
    CASE 
        WHEN u1.user_id < u2.user_id THEN u1.user_id
        ELSE u2.user_id
    END,
    CASE 
        WHEN u1.user_id > u2.user_id THEN u1.user_id
        ELSE u2.user_id
    END,
    NOW(), 
    NOW()
FROM likematch AS u1
JOIN likematch AS u2 ON u1.user_id = u2.target_user_id AND u1.target_user_id = u2.user_id
WHERE u1.click_type = 'like' AND u2.click_type = 'like'
AND NOT EXISTS (
    SELECT 1 FROM usermatch
    WHERE (user1_id = LEAST(u1.user_id, u2.user_id) AND user2_id = GREATEST(u1.user_id, u2.user_id))
);






INSERT INTO users VALUES(NULL, 'user', 'Ángel','Higuero','higueromora','higueromora@hotmail.com','pass',null,CURTIME(),CURTIME(),NULL);

INSERT INTO users VALUES(NULL, 'user', 'Juan','Lopez','juanlopez','juan@juan.com','pass',null,CURTIME(),CURTIME(),NULL);

INSERT INTO users VALUES(NULL, 'user', 'Manolo','Garcia','manologarcia','manolo@manolo.com','pass',null,CURTIME(),CURTIME(),NULL);

