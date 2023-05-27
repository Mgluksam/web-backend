<?php
$servername = "localhost";
$username = "u52401";
$password = "7321086";
$dbname = "u52401";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $id = $_POST['id'];
    $table = $_POST['table'];

    // SQL-запрос для удаления записи
    $sql = "DELETE FROM $table WHERE application_id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Запись успешно удалена!";
    }
} catch (PDOException $e) {
    echo "Ошибка при удалении записи: " . $e->getMessage();
}

$conn = null;
?>