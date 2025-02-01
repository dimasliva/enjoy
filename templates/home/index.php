<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>First Englis</title>
  <link rel="stylesheet" href="<?= HOME_PAGE['FOLDER'] ?>/index.css">
  <script src="<?= HOME_PAGE['FOLDER'] ?>/index.js" defer></script>
</head>


<body>
  <div class="container"></div>

  <header class="header__main">
    <img src="templates/home/img/hacker.jpg" alt="Изображение хакера" class="header__img">
    <nav>
    <a href="<?= REGISTER_PAGE['URL'] ?>" class="header__a">Зарегистрироваться</a>
    <a href="<?= AUTH_PAGE['URL'] ?>" class="header__a">Войти</a>
    </nav>
  </header>


</body>

</html>