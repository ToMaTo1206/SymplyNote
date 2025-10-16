<?php

declare(strict_types=1);

require_once __DIR__.'/../src/Authentication/UserAuthentication.php';
require_once __DIR__.'/../vendor/autoload.php';

use Authentication\Exception\NotLoggedInException;
use Authentication\UserAuthentication;
use Entity\Exception\EntityNotFoundException;
use Html\AppWebPage;
use Service\Exception\SessionException;

$authentication = new UserAuthentication();
$p = new AppWebPage('Authentification');

try {
    if ('POST' === $_SERVER['REQUEST_METHOD']) {
        $user = $authentication->getUserFromAuthentication();
        header('Location: index.php');
        exit;
    }
} catch (EntityNotFoundException|SessionException|NotLoggedInException $e) {
    $p->appendContent('<p style="color:red;">'.htmlspecialchars($e->getMessage()).'</p>');
}

// CSS
$p->appendCSS(<<<CSS
form input {
    width: 8em;
    margin: 0.5em;
}
CSS);

$form = $authentication->loginForm('form.php', 'Se connecter');

$p->appendContent(<<<HTML
    <div class="d-flex flex-column justify-content-center align-items-center flex-grow-1">
    <h1>Connexion</h1>
    {$form}
    <a href="addUser.php">Pas de compte ?</a>
    </div>
HTML);

echo $p->toHTML();
