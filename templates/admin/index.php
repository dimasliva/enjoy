<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= ADMIN_PAGE['NAME'] ?></title>
  <link rel="stylesheet" href="<?= ADMIN_PAGE['FOLDER'] ?>/index.css">
  <script src="<?= ADMIN_PAGE['FOLDER'] ?>/index.js" defer></script>
</head>

<body>
  <div>
    <h2>Таблица пользователей</h2>
    <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
        <th>Действия</th>
      </tr>
    </thead>
    <tbody>
      <?php if(empty($users)): ?>
      <tr>
        <td colspan="4">Нет пользователей</td>
      </tr>
        <?php else: ?>
          <?php foreach($users as $user): ?>
              <tr>
                <td class="td_user_id"> <?= htmlspecialchars($user['id'])?> </td>
                <td> 
                  <div class="td_field">
                    <?= htmlspecialchars($user['name'])?>
                  </div> 
                </td>
                <td> 
                  <div class="td_field">
                    <?= htmlspecialchars($user['role'])?>
                  </div> 
              </td>
                <td> 
                  <div class="flex items-center gap-4">
                    <form action="" method="POST" class="edit_form">
                      <input type="hidden" name="id" value="<?=htmlspecialchars($user['id'])?>">
                      <input type="text" name="name" value="<?=htmlspecialchars($user['name'])?>">
                      <select class="input_field" name="role" required>
                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''?>>Admin</option>
                        <option value="user" <?= $user['role'] == 'user' ? 'selected' : ''?>>User</option>
                      </select>
                      <button type="submit" name="edit">Редактировать</button>
                    </form>

                    <form action="" method="POST" class="delete_form">
                      <input type="hidden" name="id" value="<?= htmlspecialchars($user['id'])?>"/>
                      <button type="submit" name="delete">Удалить</button>
                    </form>

                    <form action="" method="POST" class="password_form">
                      <input type="hidden" name="id" value="<?=htmlspecialchars($user['id'])?>">
                      <input type="password" name="new_password" placeholder="Новый пароль" class="input_field" required>
                      <button type="submit" name="change_password" class="btn_success">Изменить пароль</button>
                    </form>
                  </div>

                </td>
              </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
  </table>
  </div>
  <div class="wrapper_acces_lessons">
    <h2>Форма доступа к lessons</h2>
    <form action="" method="POST" class="flex items-center gap-4 mb-4 user_form">
      <div class="user_form__access">
      <div class="flex items-center">
        <label for="userId">Пользователь:</label>
        <select class="input_field" id="userId" name="userId">
          <option value="">Выберите пользователя</option>
          <?php foreach($users as $user): ?>
            <option value="<?= htmlspecialchars($user['id'])?>"><?= htmlspecialchars($user['name'])?></option>
            <?php endforeach; ?>
        </select>
      </div>  
      <div class="flex items-center">
        <label for="lessonId">Урок:</label>
        <select class="input_field" name="lessonId" id="lessonId">
        <option value="">Выберите урок</option>
          <?php foreach($lessons as $lesson): ?>
            <option value="<?= htmlspecialchars($lesson['id'])?>"><?= htmlspecialchars($lesson['name'])?></option>
          <?php endforeach; ?>
        </select>
        
      </div>
      </div>
 
      <button type="submit" name="accessLesson">Добавить доступ</button>
    </form>
    <table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Lessons</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($accessLessons as $accessLesson): ?>
            <tr>
                <td>
                    <?= htmlspecialchars($accessLesson['username']) ?>
                </td>
                <td>
                    <?= htmlspecialchars($accessLesson['lesson_names']) ?>
                </td>
                <td>
                    <form action="" method="POST">
                        <input type="hidden" name="accessLessonId" value="<?= htmlspecialchars($accessLesson['id']) ?>">
                        <button type="submit" name="removeAccess" class="bg-warning">Удалить доступ</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
  </div>

  <div>
    <h2>Файлы ответов</h2>
     <table>
      <thead>
        <tr>
          <th>Файл</th>
          <th>Действия</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($files as $file): ?>
          <?php if($file !== '.' && $file !== '..'): ?>
            <tr>
              <td>
                <?= htmlspecialchars($file);?>
              </td>
              <td>
                <div class="flex gap-4">
                <a href="/uploads/<?= urlencode($file);?>" class="btn_success" download>Скачать</a>

                <form action="" method="POST" class="flex items-center gap-4">
                  <input type="hidden" name="file" value="<?= htmlspecialchars($file);?>">
                  <button type="submit" name="delete_file" class="btn_danger">Удалить</button>
                </form>
                </div>

              </td>
            </tr>
            <?php endif;?>
 
          <?php endforeach; ?>

      </tbody>
    </table>
  </div>

  <div>
    <h2>Вопросы к урокам</h2>
    <form method="POST">
        <select name="lesson_id" class="input_field" required>
            <?php foreach ($lessons as $lesson): ?>
                <option value="<?php echo $lesson['id']; ?>"><?php echo htmlspecialchars($lesson['name']); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" class="input_field" name="text" placeholder="Введите текст вопроса" required>
        <button type="submit" name="add_question" class="btn_success">Добавить вопрос</button>
    </form>
     <table>
      <thead>
        <tr>
          <th>Урок</th>
          <th>Вопрос</th>
          <th>Действия</th>
        </tr>
      </thead>
      <tbody>
            <?php foreach ($questions as $question): ?>
                <tr>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $question['id']; ?>">
                            <input type="hidden" name="lesson_id" value="<?php echo $question['lesson_id']; ?>">
                            <select class="input_field" name="lesson_id" required>
                                <?php foreach ($lessons as $lesson): ?>
                                    <option value="<?php echo $lesson['id']; ?>" <?php echo $lesson['id'] == $question['lesson_id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($lesson['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <input type="text" name="text" value="<?php echo htmlspecialchars($question['text']); ?>" required>
                            <button type="submit" name="edit_question" class="btn_success">Сохранить</button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $question['id']; ?>">
                            <button type="submit" name="delete_question" class="btn_danger">Удалить</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
  </div>
</body>

</html>