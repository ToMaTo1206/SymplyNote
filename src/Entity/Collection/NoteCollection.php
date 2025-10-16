<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Note;

class NoteCollection
{
    public static function findAllNotesFromUser(int $userId): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
    SELECT id, user_id, title, content, created_at, updated_at 
    FROM note
    WHERE user_id = :user_id
    ORDER BY created_at
SQL);

        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, Note::class);
    }
}
