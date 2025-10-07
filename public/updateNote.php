<?php

declare(strict_types=1);

use Authentication\Exception\NotLoggedInException;
use Authentication\UserAuthentication;
use Html\AppWebPage;
use Service\Exception\SessionException;
use Entity\Note;

require_once __DIR__ . '/../vendor/autoload.php';

$auth = new UserAuthentication();

try {
    if (!$auth->isUserConnected()) {
        header('Location: form.php');
        exit;
    }
    $user = $auth->getUser();
} catch (SessionException|NotLoggedInException $e) {
    header('Location: form.php');
    exit;
}

// Vérifie si un ID de note est fourni
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header('Location: notes.php');
    exit;
}

$noteId = (int) $_GET['id'];

$note = Note::findNoteById($noteId);

if ($note->getUserId() !== $user->getId()) {
    header('Location: notes.php');
    exit;
}

$webPage = new AppWebPage("Modifier la note");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title === '' || $content === '') {
        $webPage->appendContent("<p style='color:red;'>Veuillez remplir tous les champs.</p>");
    } else {
        $note->setTitle($title);
        $note->setContent($content);
        $note->updateNote();

        header('Location: notes.php');
        exit;
    }
}

$escapedTitle = htmlspecialchars($note->getTitle(), ENT_QUOTES);
$escapedContent = htmlspecialchars($note->getContent(), ENT_QUOTES);

$webPage->appendContent(<<<HTML
<form method="post" class="noteForm">
    <label for="title">Titre :</label><br>
    <input type="text" id="title" name="title" value="$escapedTitle" required><br><br>

    <label for="content">Contenu :</label><br>
    <textarea id="content" name="content" rows="6" cols="40" required>$escapedContent</textarea><br><br>

    <button type="submit">Enregistrer les modifications</button>
</form>
HTML);

echo $webPage->toHTML();
