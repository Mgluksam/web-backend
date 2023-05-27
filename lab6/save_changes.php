<?php
// Подключение к базе данных
$servername = "localhost";
$username = "u52401";
$password = "7321086";
$dbname = "u52401";
$table = $_POST['table']; // Имя таблицы, которую нужно обновить
$recordId = $_POST['recordId']; // Идентификатор записи

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Формирование SQL-запроса для обновления данных
$query = "UPDATE $table SET ";
foreach ($_POST as $fieldName => $fieldValue) {
    if ($fieldName != 'recordId' and $fieldName!='table') {
        $query .= "$fieldName = '$fieldValue', ";
    }
}
$query = rtrim($query, ", ");

$query .= " WHERE application_id = $recordId";

echo $query;
// Выполнение SQL-запроса
if ($conn->query($query) === TRUE) {
    echo "Изменения сохранены";
} else {
    echo "Ошибка при сохранении изменений: " . $conn->error;
}

// Закрытие соединения с базой данных
$conn->close();
?>