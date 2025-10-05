<?php

namespace Entity;

use Database\MyPdo;

class Note
{
    private int $noteId;

    private string $title;
    private string $content;

    private string $createdAt;

    private string $updatedAt;

    public function getNoteId(): int
    {
        return $this->noteId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public static function findNoteById(int $id): Note
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
    SELECT id, description
    FROM category
    WHERE id = :id
SQL);

        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject(Note::class);
    }

}
