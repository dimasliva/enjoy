<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lesson - 1</title>
  <link rel="stylesheet" href="<?= QUESTION_PAGE['FOLDER'] ?>/index.css">
  <script src="<?= QUESTION_PAGE['FOLDER'] ?>/index.js" defer></script>
</head>

<body>
  <main class="wrapper">
    <div class="form-container">
      <div class="container">

        <form action="" method="POST" class="form">
          <?php foreach ($questions as $question): ?>
            <div class="form-group">
              <label for="question-<?= $question['id'] ?>" class="form-label">
                <?= htmlspecialchars($question['text']) ?>
              </label>
              <input type="text" id="question-<?= $question['id'] ?>" name="answer[<?= $question['id'] ?>]"
                placeholder="Ваш ответ" class="form-input">
            </div>
          <?php endforeach; ?>
          <button type="submit" name="submit" id="submit" class="form-container__submit">
            Отправить
          </button>
        </form>
      </div>
    </div>
  </main>
</body>

</html>