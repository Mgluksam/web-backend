<head>
  <title>lab5</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
  <script defer src="script.js"></script>
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <?php
  $login = isset($_COOKIE['login']) ? $_COOKIE['login'] : '';

  // Установка параметров подключения к базе данных
  $hostname = 'localhost'; // Имя хоста базы данных
  $username = 'u52401'; // Имя пользователя базы данных
  $password = '7321086'; // Пароль пользователя базы данных
  $database = 'application'; // Имя базы данных
  
  try {
    // Подключение к базе данных
    $db = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8", $username, $password);

    // Подготовка и выполнение запроса
    $stmt = $db->prepare("SELECT app_id FROM users WHERE login = :login");
    $stmt->bindParam(':login', $login);
    $stmt->execute();

    // Получение результата запроса
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Вывод значения столбца "app_id"
  } catch (PDOException $e) {
    // Обработка ошибки подключения к базе данных
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
  }

  try {
    // Подключение к базе данных
    $db = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8", $username, $password);

    // Подготовка и выполнение запроса
    $stmt = $db->prepare("SELECT name, email FROM application WHERE application_id = :result");
    $stmt->bindParam(':result', $result['app_id']);
    $stmt->execute();

    // Получение результата запроса
    $nextResult = $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    // Обработка ошибки подключения к базе данных
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
  }

  ?>
  <div class="container my-5">

    <form class="ajaxForm" id="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" accept-charset="UTF-8">
      <div class="col mb-3">
        <label for="InputName" class="form-label">
          <?php echo 'Добро пожаловать, ' . $login ?>
        </label><br>
        <label for="InputName" class="form-label">Поле изменения имени</label>
        <input type="text" name="name" placeholder="Введите новое имя"
          class="form-control checkReq" id="FormName" aria-describedby="format" required />
      </div>
      <div class="col mb-3">
        <label for="InputEmail1" class="form-label">Поле изменения адреса электронной почты</label>
        <input type="email" name="email" class="form-control checkReq"
          id="FormEmail" aria-describedby="emailHelp" placeholder="name@example.com" />
        <div id="emailHelp" class="form-text">
          Подтверждение адреса электронной почты не требуется.
        </div>
      </div>
      <div class="col"><button type="submit" id="submitButton" class="btn btn-success">Сохранить</button></div>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      try {

        $db = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8", $username, $password);

        // Устанавливаем режим обработки ошибок PDO на исключения
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Подготавливаем SQL-запрос для обновления полей name и email
        $stmt = $db->prepare("UPDATE application SET name = :name, email = :email WHERE application_id = :appId");

        // Привязываем значения к параметрам в SQL-запросе
        $stmt->bindParam(':name', $_POST['name']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':appId', $result['app_id']);
        // Выполняем SQL-запрос
        $stmt->execute();

        echo '<div class="alert alert-success">Данные успешно обновлены</div>';
      } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Ошибка при выполнении запроса:</div>';
        echo $e->getMessage();
      }
    }
    ?>
  </div>
</body>