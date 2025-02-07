<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Вход</title>
  <link rel="stylesheet" href="<?= AUTH_PAGE['FOLDER'] ?>/index.css">
  <script src="<?= AUTH_PAGE['FOLDER'] ?>/index.js" defer></script>
</head>

<body>
  <div class="auth-page">
    <div class="auth-page__content">
      <h1 class="auth-page__title">Вход</h1>
      <form class="auth-page__form" method="POST" action="">
        <input type="text" placeholder="Введите логин" class="auth-page__input" name="name" id="name" />
        <input type="password" placeholder="Введите пароль" class="auth-page__input" id="pass" name="password" />
        <div>
          <button type="submit" name="login" class="auth-page__submit">Войти</button>
        </div>
      </form>
      <!-- <button id="auth" class="auth-page__submit">Войти</button> -->
    </div>
  </div>
</body>

</html>