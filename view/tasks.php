<?php
/**
 * @var Task $task
 */
?>
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
            crossorigin="anonymous">
</head>
<body>
<div class="container text-center">
<h1><?= $pageHeader ?></h1>
Добро пожаловать <?=$username?>! <a href="/?controller=security&action=logout">Выйти</a>
<a href="/">Главная</a>
<br><br>
<form action="/?controller=tasks&action=add" method="post">
    <input type="text" name="task" placeholder="Опишите новую задачу">
    <input type="submit" value="Добавить">
</form>
</div>
<div class="container text-center">
<h3>Список активных задач</h3>
<?php foreach ($tasks as $task): ?>
    <div id="<?=$task->getId()?>">
        <?= $task->getDescription() ?>
<!--        <a href="/?controller=tasks&action=done&id=<?//=$task->getId()?>">[Done]</a>-->
        <button class="done" data-id="<?=$task->getId()?>">Done</button>
    </div>
<?php endforeach; ?>
</div>

<script>
    let buttons = document.querySelectorAll('.done');
    buttons.forEach((elem) => {
        elem.addEventListener('click', () => {
            let id = elem.getAttribute('data-id');
            (
                async () => {
                    const response = await fetch('/?controller=tasks&action=apidone&id=' + id);
                    const answer = await response.json();
                    document.getElementById(answer.task_id).remove();
                }
            )();
        })
    })
</script>
</body>
