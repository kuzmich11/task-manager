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

<?php if (is_null($username)): ?>
    <a href="/?controller=security">Войти</a>
    <a href="?controller=registration">[Зарегистрироваться]</a>
<?php else: ?>
   Добро пожаловать <?=$username?>! <a href="/?controller=security&action=logout">Выйти</a>
   <a href="/?controller=tasks">Задачи</a>

<?php endif; ?>
</div>
</body>