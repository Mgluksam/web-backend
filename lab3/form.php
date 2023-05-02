<?php
print_r($_POST);
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // проверяем, заполнены ли обязательные поля
  if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['ability']) || empty($_POST['born']) || empty($_POST['gender']) || empty($_POST['num_of_limbs']) || empty($_POST['text']) || empty($_POST['check'])) {
    echo("Данные введены некорректно, попробуйте ещё раз");
    exit;
  } else {
    // получаем значения полей
    $name = $_POST['name'];
    $email = $_POST['email'];
    $born = $_POST['born'];
    $gender = $_POST['gender'];
    $radio = $_POST['num_of_limbs'];
    $abilities = $_POST['ability'];
    $text = $_POST['text'];
    $check = $_POST['check'];

    // проверяем правильность заполнения поля email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo 'Введите правильный email';
    } else {
        $user = 'u52401'; // Заменить на ваш логин uXXXXX
        $pass = '7321086'; // Заменить на пароль, такой же, как от SSH
        $db = new PDO('mysql:host=localhost;dbname=u52401', $user, $pass,
          [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
      try {
        $stmt = $db->prepare("INSERT INTO application VALUES (null,:name,:email,:born,:gender,:num_of_limbs,:text)");
        $stmt -> execute(['name'=>$_POST['name'], 'email'=>$_POST['email'],'born'=>$_POST['born'],'gender'=>$_POST['gender'],'num_of_limbs'=>$_POST['num_of_limbs'],'text'=>$_POST['text']]);      
        $ap_id = $db->lastInsertId();
        foreach ($_POST['ability'] as $ab_id) {
          $stmt = $db->prepare("INSERT INTO application_ability VALUES (null,:ap_id,:ab_id)");
          $stmt -> execute(['ap_id'=>$ap_id, 'ab_id'=>$ab_id]);
        }
      }
      catch(PDOException $e){
          print('Error : ' . $e->getMessage());
          exit();
      }
      print("Данные внесены в базу данных");
    }
  }
}
?>
