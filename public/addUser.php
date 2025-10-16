<?php

declare(strict_types=1);

use Authentication\Exception\NotLoggedInException;
use Authentication\UserAuthentication;
use Entity\Note;
use Entity\User;
use Html\AppWebPage;
use Service\Exception\SessionException;

require_once __DIR__.'/../vendor/autoload.php';

$authentification = new UserAuthentication();

try {
    $authentification->logoutIfRequested();

    if ($authentification->isUserConnected()) {
        header('Location: index.php');
        exit;
    }
} catch (SessionException|NotLoggedInException $e) {
    header('Location: form.php');
    exit;
}

$webPage = new AppWebPage('Inscription');

// Si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données
    $firstName = trim($_POST['prenom'] ?? '');
    $lastName = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['mdp'] ?? ''; // Pas de trim sur le mot de passe

    // Validation simple
    if (empty($firstName) || empty($lastName) || empty($email) || empty($login) || empty($password)) {
        $webPage->appendContent("<div class='alert alert-danger'>Veuillez remplir tous les champs.</div>");
    } else {
        try {
            // Création de l'utilisateur
            $user = new User();
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setEmail($email);
            $user->setLogin($login);
            $user->setPassword($password); // La méthode setPassword s'occupe du hachage
            // Le téléphone est optionnel, on peut l'ajouter ici si on a le champ
            // $user->setPhone(trim($_POST['phone'] ?? ''));

            $user->createUser();

            // Redirection vers la page de connexion après une inscription réussie
            header('Location: form.php');
            exit;
        } catch (\PDOException $e) {
            // Gère le cas où le login ou l'email existent déjà (contrainte UNIQUE dans la DB)
            $webPage->appendContent("<div class='alert alert-danger'>Ce login ou cet email est déjà utilisé.</div>");
        }
    }
}


// Formulaire HTML
$webPage->appendContent(<<<HTML
<form method="post" class="">
    <label for="prenom">Prenom :</label><br>
    <input type="text" id="prenom" name="prenom" required><br><br>
    
    <label for="nom">Nom :</label><br>
    <input type="text" id="nom" name="nom" required><br><br>

    <label for="email">Email :</label><br>
    <input type="text" id="email" name="email" required><br><br>
    
    <label for="login">Login :</label><br>
    <input type="text" id="login" name="login" required><br><br>
    
    <label for="mdp">Mot de passe :</label><br>
    <input type="text" id="mdp" name="mdp" required><br><br>

    <button type="submit">Finir l'inscription</button>
</form>
HTML);

echo $webPage->toHTML();
