<?php

declare(strict_types=1);

use Authentication\Exception\NotLoggedInException;
use Authentication\UserAuthentication;
use Html\AppWebPage;
use Service\Exception\SessionException;

require_once __DIR__.'/../vendor/autoload.php';

$authentification = new UserAuthentication();

try {
    $authentification->logoutIfRequested();
    // On vérifie si l'utilisateur est connecté
    if (!$authentification->isUserConnected()) {
        header('Location: form.php');
        exit;
    }

    // Récupération de l'utilisateur connecté depuis la session
    $user = $authentification->getUser();
} catch (SessionException|NotLoggedInException $e) {
    header('Location: form.php');
    exit;
}

$webPage = new AppWebPage('Accueil - SymplyNote');

$webPage->appendCssUrl('css/style.css');

$webPage->appendContent("<div class='content-left'>");
$webPage->appendContent(
    <<<HTML
    <h2>Bienvenue {$user->getFirstName()} {$user->getLastName()}</h2>
    <p>Login : {$user->getLogin()}</p>
    <p>Email : {$user->getEmail()}</p>
    <p>Téléphone : {$user->getPhone()}</p>
    
HTML
);

$webPage->appendContent('</div>');

$webPage->appendContent("<div class='content-right'>");
$webPage->appendContent("<a href='notes.php'>Voir toutes les notes ?</a>");
$webPage->appendContent($authentification->logoutForm('index.php', 'Se déconnecter'));
$webPage->appendContent('</div>');

echo $webPage->toHTML();
