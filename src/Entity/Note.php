<?php

namespace Entity;

use Database\MyPdo;

class Note
{
    private int $id;

    private int $user_id;
    private string $title;
    private string $content;

    private string $createdAt;

    private string $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
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
    SELECT id, user_id, title, content, created_at, updated_at 
    FROM note
    WHERE id = :id
SQL);

        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject(Note::class);
    }

    public function deleteNote(): void
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
    DELETE
    FROM note
    WHERE id = :id
SQL);

        $stmt->execute(['id' => $this->getId()]);
    }

    public function updateNote(): void
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
        UPDATE note
        SET title = :title,
            content = :content,
            updated_at = CURRENT_TIMESTAMP
        WHERE id = :id
        SQL
        );
        $stmt->execute([
            'title' => $this->title,
            'content' => $this->content,
            'id' => $this->id,
        ]);
    }

    public function addNote(): void
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
        INSERT INTO note (title, content, user_id)
        VALUES (:title, :content, :user_id)
        SQL
        );
        $stmt->execute([
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => $this->user_id,
        ]);

        $this->id = (int) MyPdo::getInstance()->lastInsertId();
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }




}
