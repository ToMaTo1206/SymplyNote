<?php
declare(strict_types=1);

use Authentication\Exception\NotLoggedInException;
use Authentication\UserAuthentication;
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

if (!isset($_GET['id'])){
    header('Location: notes.php');
}

$note = \Entity\Note::findNoteById((int) $_GET['id']);

$webPage = new AppWebPage("{$note->getTitle()}");

$webPage->appendMenu("<a href=\"notes.php\">Back to notes</a><a href='updateNote.php?id={$note->getId()}'>modifier note ?</a>");

$webPage->appendContent("<p class='note'>");
$webPage->appendContent("<p>{$note->getContent()}</p>");
$webPage->appendContent('</p>');

echo $webPage->toHTML();