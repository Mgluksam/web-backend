<?php
// Установка параметров подключения к базе данных
$hostname = 'localhost'; // Имя хоста базы данных
$username = 'u52401'; // Имя пользователя базы данных
$password = '7321086'; // Пароль пользователя базы данных
$database = 'u52401'; // Имя базы данных

try {
    // Подключение к базе данных
    $db = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8", $username, $password);

    // Подготовка и выполнение запросов для подсчета количества записей
    $stmt1 = $db->query("SELECT COUNT(*) as count FROM application_ability WHERE ab_id = 1");
    $count1 = $stmt1->fetch(PDO::FETCH_ASSOC)['count'];

    $stmt2 = $db->query("SELECT COUNT(*) as count FROM application_ability WHERE ab_id = 2");
    $count2 = $stmt2->fetch(PDO::FETCH_ASSOC)['count'];

    $stmt3 = $db->query("SELECT COUNT(*) as count FROM application_ability WHERE ab_id = 3");
    $count3 = $stmt3->fetch(PDO::FETCH_ASSOC)['count'];

    // Вывод результатов
    echo "Количество записей с ab_id = 1: " . $count1 . "<br>";
    echo "Количество записей с ab_id = 2: " . $count2 . "<br>";
    echo "Количество записей с ab_id = 3: " . $count3 . "<br>";
} catch (PDOException $e) {
    // Обработка ошибки подключения к базе данных
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
}
?>
