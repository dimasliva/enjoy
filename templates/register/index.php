<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Вход</title>
  <link rel="stylesheet" href="<?= REGISTER_PAGE['FOLDER'] ?>/index.css">
  <script src="<?= REGISTER_PAGE['FOLDER'] ?>/index.js" defer></script>
</head>

<body>
  <div class="container"></div>
  <div class="auth-page">
    <div class="auth-page__content">
      <h1 class="auth-page__title">Зарегистрироваться</h1>
      <form class="auth-page__form" method="POST" action="">
        <input type="text" placeholder="Введите логин" class="auth-page__input" name="name" id="name" />
        <input type="password" placeholder="Введите пароль" class="auth-page__input" id="pass" name="password" />
        <input type="password" placeholder="Повторите пароль" class="auth-page__input" id="repass" name="repass" />
        <div>
          <button type="submit" name="register" class="auth-page__submit">Зарегистрироваться</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>