<?php

interface ITaskProvider
{
    public function addTask(Task $task): bool;
}