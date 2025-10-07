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

    if (!$authentification->isUserConnected()) {
        header('Location: form.php');
        exit;
    }
    $user = $authentification->getUser();
} catch (SessionException|NotLoggedInException $e) {
    header('Location: form.php');
    exit;
}

$notes = Entity\Collection\NoteCollection::findAllNotesFromUser($user->getId());

$webPage = new AppWebPage('Liste des notes');

$webPage->appendContent("<div class='listNotes'>");
foreach ($notes as $note) {
    $webPage->appendContent("<div class='note'>");
    $webPage->appendContent("<a href='note.php?id={$note->getId()}'>");
    $webPage->appendContent("<p >{$note->getTitle()}</p>");
    $webPage->appendContent('</a>');
    $webPage->appendContent("<a href='note.php?id={$note->getId()}'>Supprimer ?</a>");
    $webPage->appendContent('</div>');
}
$webPage->appendContent('</div>');

echo $webPage->toHTML();
