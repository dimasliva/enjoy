<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Вход в админ панель</title>
  <link rel="stylesheet" href="<?= ADMIN_AUTH_PAGE['FOLDER'] ?>/index.css">
  <script src="<?= ADMIN_AUTH_PAGE['FOLDER'] ?>/index.js" defer></script>
</head>

<body>
  <div class="container"></div>
  <div class="auth-page">
    <div class="auth-page__content">
      <h1 class="auth-page__title">Вход в админ панель</h1>
      <?php if (isset($errorMessage)): ?>
        <div class="error-message"><?= htmlspecialchars($errorMessage) ?></div>
      <?php endif; ?>
      <form class="auth-page__form" method="POST" action="">
        <input type="text" placeholder="Введите логин" class="auth-page__input" name="name" id="name" />
        <input type="password" placeholder="Введите пароль" class="auth-page__input" id="pass" name="password" />
        <div>
          <button type="submit" name="login" class="auth-page__submit">Войти</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>
