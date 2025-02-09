<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>English</title>
  <link rel="stylesheet" href="<?= LESSONS_PAGE['FOLDER'] ?>/index.css">
  <script src="<?= LESSONS_PAGE['FOLDER'] ?>/index.js" defer></script>
</head>

<body>
  <div class="container">
    <header class="wrapper header">
      <img class="header__logo-img" src="<?= LESSONS_PAGE['FOLDER'] ?>/img/hacker.jpg" alt="Логотип">
      <h1 class="header__title">Super English</h1>
      <form action="" method="POST">
        <button name="exit" id="exit" class="header__singout-btn">Выход</button>
      </form>
    </header>
    <main class="wrapper main">
      <div class="main__pages">
        <form action="" method="POST">
          <?php for ($i = 0; $i < $totalPages; $i++): ?>
            <button type="submit" name="changePage" value="<?= $i + 1 ?>" id="changePage_<?= $i ?>"
              class="main__page-btn 
              <?php if ($_SESSION['role'] === 'user' && empty($accessibleLessonIds)): ?> 
                disable 
              <?php endif; ?>">
                <?= ($i * $perPage) + 1 ?> - <?= ($i + 1) * $perPage ?>
            </button>
          <?php endfor; ?>
        </form>
      </div>
      <ul class="lessons">
        <?php foreach ($allLessons as $lesson): ?>
          <li class="lesson-item">
            <form action="" method="POST">
              <?php if (in_array($lesson['id'], $accessibleLessonIds) || $_SESSION['role'] === 'admin'): ?>
                <button name="to_lesson" id="to_lesson" class="button_lesson" value="<?= $lesson['id'] ?>">
                  <?= htmlspecialchars($lesson['name']); ?>
                </button>
              <?php else: ?>
                <button name="disable_lesson" id="disable_lesson" class="button_lesson" value="<?= $lesson['id'] ?>">
                  <?= htmlspecialchars($lesson['name']); ?>
                  <span class="lock_img"></span>
                </button>
              <?php endif; ?>
            </form>
          </li>
        <?php endforeach; ?>
      </ul>
    </main>
  </div>
</body>

</html>