<?php

include_once "exceptions/TaskAlreadyIsDoneException.php";

class TaskProvider implements ITaskProvider
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    /**
     * @throws TaskAlreadyIsDoneException
     */
    public function doDoneTask(?int $task_id, ?int $user_id): void
    {
        $statement = $this->pdo->prepare(
            'UPDATE tasks SET isDone = 1 WHERE id = :id AND user_id = :user_id AND isDone != 1'
        );

       $statement->execute([
            'user_id' => $user_id,
            'id' => $task_id,
        ]);

       if ($statement->rowCount() == 0) {
           throw new TaskAlreadyIsDoneException("Задача не может быть выполнена");
       }

    }

    public function getUndoneList(int $userId): array
    {
        $statement = $this->pdo->prepare(
            'SELECT * FROM tasks WHERE isDone = 0 AND user_id = :id'
        );

        $statement->execute([
            'id' => $userId,
        ]);

        return $statement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Task::class);
    }


    public function addTask(Task $task): bool
    {
        
        $statement = $this->pdo->prepare(
            'INSERT INTO tasks (user_id, description) VALUES (:user_id, :description)'
        );

        return $statement->execute([
            'user_id' => $_SESSION['user_id'],
            'description' => $task->getDescription()
        ]);
    }


}