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
                <td> <?= htmlspecialchars($user['id'])?> </td>
                <td> <?= htmlspecialchars($user['name'])?> </td>
                <td> <?= htmlspecialchars($user['role'])?> </td>
                <td> 
                  <div class="flex items-center">
                  <form action="" method="POST" class="edit_form">
                    <input type="hidden" name="id" value="<?=htmlspecialchars($user['id'])?>">
                    <input type="text" name="name" value="<?=htmlspecialchars($user['name'])?>">
                    <select name="role" required>
                      <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''?>>Admin</option>
                      <option value="user" <?= $user['role'] == 'user' ? 'selected' : ''?>>User</option>
                    </select>
                    <button type="submit" name="edit">Редактировать</button>
                  </form>

                  <form action="" method="POST" class="delete_form">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id'])?>"/>
                    <button type="submit" name="delete">Удалить</button>
                  </form>
                  </div>

                </td>
              </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
  </table>
  </div>
          <div>
    <h2>Форма доступа к lessons</h2>
    <form action="" method="POST" class="flex items-center gap-4 mb-4">
      <div class="flex items-center">
        <label for="userId">Пользователь:</label>
        <select id="userId" name="userId">
          <option value="">Выберите пользователя</option>
          <?php foreach($users as $user): ?>
            <option value="<?= htmlspecialchars($user['id'])?>"><?= htmlspecialchars($user['name'])?></option>
            <?php endforeach; ?>
        </select>
      </div>  
      <div class="flex items-center">
        <label for="lessonId">Урок:</label>
        <select name="lessonId" id="lessonId">
        <option value="">Выберите урок</option>
          <?php foreach($lessons as $lesson): ?>
            <option value="<?= htmlspecialchars($lesson['id'])?>"><?= htmlspecialchars($lesson['name'])?></option>
          <?php endforeach; ?>
        </select>
        </select>
      </div>
      <button type="submit" name="accessLesson">Добавить доступ</button>
    </form>
     <table>
    <thead>
      <tr>
        <th>Username</th>
        <th>Lesson</th>
        <th>Действия</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($accessLessons as $accessLesson): ?>
        <tr>
          <td>
            <?= htmlspecialchars($accessLesson['username'])?>
          </td>
          <td>
          <?= htmlspecialchars($accessLesson['lesson_name'])?>

          </td>
          <td>
            <form action="" method="POST">
              <input type="hidden" name="accessLessonId" value="<?= htmlspecialchars($accessLesson['id'])?>">
              <button type="submit" name="removeAccess" class="bg-warning">Удалить доступ</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
          </div>
</body>

</html>