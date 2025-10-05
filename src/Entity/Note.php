<?php

namespace Entity;

class Note
{
    private int $noteId;

    private string $title;
    private string $content;

    private string $createdAt;

    private string $updatedAt;

    /**
     * @return int
     */
    public function getNoteId(): int
    {
        return $this->noteId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }



}
