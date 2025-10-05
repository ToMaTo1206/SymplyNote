# SymplyNote 
### Crée par Thomas Denoyelle !

## Présentation :
SymplyNote est une application web qui permet à un utilisateur de faire des notes, qu'elles soient simples ou détaillées.

## Projet : 
Ce projet utilisera principalement du php et phpmyamdin.
C'est un projet qui sera fait en paralèlle de mes études !

## Serveur local
Pour lancer le serveur local, j'utilise XAMPP. 
Cela me permet d'avoir des outils comme MySql et phpmyadmin pour tester le fonctionnement du projet.

## Base de donnée
Pour la base de donnée, j'utilise PhpMyAdmin. Pour tester de votre côté, suivé les instructions qui suivent :
Tout d'abord, créé une nouvelle base de donnée sur PhpMyAdmin qui s'appellera symplyNote.
Ensuite, allé dans la partie SQL pour pouvoir rentrer les requetes de création de table suivante :

Pour user :

CREATE TABLE user (
id INT AUTO_INCREMENT PRIMARY KEY,
firstName VARCHAR(50) NOT NULL,
lastName VARCHAR(50) NOT NULL,
email VARCHAR(100) NOT NULL,
login VARCHAR(50) NOT NULL UNIQUE,
sha512pass CHAR(128) NOT NULL,
phone VARCHAR(20)
);

Pour ajouter un utilisateur de test :
INSERT INTO user (firstName, lastName, email, login, sha512pass, phone)
VALUES ('votrePrénom', 'votreNom', 'votreEmail', 'votreLogin', SHA2('votreMdp', 512), 'votrePhone');

Pour note:
CREATE TABLE note ( id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
user_id INT UNSIGNED NOT NULL, title VARCHAR(255) NOT NULL, 
content TEXT NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE );




Le projet est encore en développement est continu à évoluer !
