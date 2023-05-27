<?php
include('style.php');
echo '<style>body{flex-direction:row;}</style>';

function authenticate() {
    header('WWW-Authenticate: Basic realm="Test Authentication System"');
    header('HTTP/1.0 401 Unauthorized');
    echo "<div class='d-flex flex-column m-auto my-2'>";
    echo "<div class='col m-auto mt-5'>Вы должны ввести корректный логин и пароль для получения доступа к ресурсу</div>";
    echo "<a class='btn btn-primary m-auto mt-1' href='./'>Попробовать еще раз</a>";
    echo "</div>";
    exit;
}

if(isset($_COOKIE['auth']) || empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW'])){
    setcookie('auth',NULL,1);
    authenticate();
}
$t = '';
try{
    include('connection.php');
    $stmt = $db->prepare("select password_hash from users where login=:login");
    $stmt->execute(['login'=>$_SERVER['PHP_AUTH_USER']]);
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $t = $stmt->fetchColumn();
} catch(PDOException $e){
    die($e->getMessage());
}
if(!password_verify($_SERVER['PHP_AUTH_PW'],$t)){
    setcookie('auth',NULL,1);
    authenticate();
}
setcookie('auth',1);
header('Location: admin.php');
?>