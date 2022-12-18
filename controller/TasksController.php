<?php
require_once 'model/Base.php';
include_once "model/User.php";
include_once "model/Task.php";
include_once "model/ITask.php";
include_once "model/TaskProvider.php";
include_once "exceptions/TaskAlreadyIsDoneException.php";

$pdo = require 'db.php';

session_start();

//Получаем текущего пользователя, если он залогинен
$username = null;
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user']->getUsername();
} else {
    //Перенаправим на главную если пользователь не залогинен
    header("Location: /");
    die();
}

$taskProvider = new TaskProvider($pdo);

if (isset($_GET['action']) && $_GET['action'] === 'add') {

        if (empty($_POST['task'])) {
            throw new Exception("Нет задачи");
        }


    $taskProvider->addTask(new Task($_POST['task']));
    header("Location: /?controller=tasks");
    die();
}




if (isset($_GET['action']) && $_GET['action'] === 'done') {
    $task_id = $_GET['id'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    try {
        $taskProvider->doDoneTask($task_id, $user_id);
    } catch (TaskAlreadyIsDoneException $e) {
        Die($e->getMessage());
    }

    header("Location: /?controller=tasks");
    die();
}



if (isset($_GET['action']) && $_GET['action'] === 'apidone') {
    $task_id = $_GET['id'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    $response = [
        'status' => 'ok',
        'task_id' => $task_id
    ];

    try {
       $taskProvider->doDoneTask($task_id, $user_id);
    } catch (TaskAlreadyIsDoneException $e) {
        $response = [
            'status' => 'error',
            'error_message' => $e->getMessage(),
            'task_id' => $task_id
        ];
    }


    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    die();

}

$pageHeader = "Задачи";

$userId = $_SESSION['user_id'];
$tasks = $taskProvider->getUndoneList($userId);


include "view/tasks.php";