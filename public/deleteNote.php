<?php

declare(strict_types=1);

use Authentication\UserAuthentication;
use Database\MyPdo;
use Entity\Note;
use Authentication\Exception\NotLoggedInException;
use Service\Exception\SessionException;

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

// Vérifie qu’un ID est bien passé
if (!isset($_GET['id'])) {
    header('Location: notes.php');
    exit;
}

$id = (int)$_GET['id'];

// Récupère la note
$note = \Entity\Note::findNoteById($id);

if (!$note) {
    die('Note introuvable.');
}

// Vérifie que la note appartient bien à l’utilisateur connecté
if ($note->getUserId() !== $user->getId()) {
    die('Action non autorisée.');
}

// Supprime la note
$note->deleteNote();

// Retourne à la liste
header('Location: notes.php');
exit;
