<?php

declare(strict_types=1);

use Authentication\Exception\NotLoggedInException;
use Authentication\UserAuthentication;
use Entity\Note;
use Html\AppWebPage;
use Service\Exception\SessionException;

require_once __DIR__ . '/../vendor/autoload.php';

$authentification = new UserAuthentication();

try {
    $authentification->logoutIfRequested();

    if (!$authentification->isUserConnected()) {
        header('Location: form.php');
        exit;
    }
    $user = $authentification->getUser();
} catch (SessionException|NotLoggedInException $e) {
    header('Location: form.php');
    exit;
}

$webPage = new AppWebPage('Nouvelle note');

// Si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title === '' || $content === '') {
        $webPage->appendContent("<p style='color:red;'>Veuillez remplir tous les champs.</p>");
    } else {
        // Création de la note
        $note = new Note();
        $note->setTitle($title);
        $note->setContent($content);
        $note->setUserId($user->getId());
        $note->addNote();

        header('Location: notes.php');
        exit;
    }
}

// Formulaire HTML
$webPage->appendContent(<<<HTML
<form method="post" class="noteForm">
    <label for="title">Titre :</label><br>
    <input type="text" id="title" name="title" required><br><br>

    <label for="content">Contenu :</label><br>
    <textarea id="content" name="content" rows="6" cols="40" required></textarea><br><br>

    <button type="submit">Ajouter la note</button>
</form>
HTML);

echo $webPage->toHTML();

