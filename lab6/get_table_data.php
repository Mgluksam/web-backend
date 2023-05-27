<?php
// Подключение к базе данных
$servername = "localhost";
$username = "u52401";
$password = "7321086";
$dbname = "u52401";
$table = $_GET['tableName'];
// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Запрос на получение данных таблицы (пример)
$query = "SELECT * FROM $table";
$result = $conn->query($query);

// Проверка результата запроса
if ($result->num_rows > 0) {
    $data = array(
        "columns" => array(), // Столбцы таблицы
        "rows" => array() // Строки таблицы
    );

    // Получение столбцов таблицы
    while ($column = $result->fetch_field()) {
        $data["columns"][] = $column->name;
    }

    // Получение данных таблицы
    while ($row = $result->fetch_assoc()) {
        $data["rows"][] = $row;
    }

    // Возвращение данных в формате JSON
    header("Content-Type: application/json");
    echo json_encode($data);
} else {
    echo "Нет данных";
}

// Закрытие соединения с базой данных
$conn->close();
?>
