<?php

class Task extends Base
{


    private string $description;
    private bool $isDone;

    public function __construct(string $description = '', bool $isDone = false)
    {
        $this->description = $description;
        $this->isDone = $isDone;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->isDone;
    }

    /**
     * @param bool $isDone
     */
    public function setIsDone(bool $isDone): void
    {
        $this->isDone = $isDone;
    }





}