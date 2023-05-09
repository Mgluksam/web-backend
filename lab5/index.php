<head>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #27011ff2;
        }

        a:hover,
        a:focus {
            outline: none;
            text-decoration: none;
        }

        .tab {
            margin-top: 20%;
            background: #200122;
            background: -webkit-linear-gradient(to bottom, #6f0000, #200122);
            background: linear-gradient(to bottom, #6f0000, #200122);
            padding: 40px 50px;
            position: relative;
        }

        .tab:before {
            content: "";
            width: 100%;
            height: 100%;
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0.85;
        }

        .tab .nav-tabs {
            border-bottom: none;
            padding: 0 20px;
            position: relative;
        }

        .tab .nav-tabs li {
            margin: 0 30px 0 0;
        }

        .tab .nav-tabs li a {
            font-size: 18px;
            color: #fff;
            border-radius: 0;
            text-transform: uppercase;
            background: transparent;
            padding: 0;
            margin-right: 0;
            border: none;
            border-bottom: 2px solid transparent;
            opacity: 0.5;
            position: relative;
            transition: all 0.5s ease 0s;
        }

        .tab .nav-tabs li a:hover {
            background: transparent;
        }

        .tab .nav-tabs li.active a,
        .tab .nav-tabs li.active a:focus,
        .tab .nav-tabs li.active a:hover {
            border: none;
            background: transparent;
            opacity: 1;
            border-bottom: 2px solid #eec111;
            color: #fff;
        }

        .tab .tab-content {
            padding: 20px 0 0 0;
            margin-top: 10px;
            background: transparent;
            z-index: 1;
            position: relative;
        }

        .form-bg {
            background: #ddd;
        }

        .form-horizontal .form-group {
            margin: 0 0 15px 0;
            position: relative;
        }

        .form-horizontal .form-control {
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 20px;
            box-shadow: none;
            padding: 0 20px;
            font-size: 14px;
            font-weight: bold;
            color: #fff;
            transition: all 0.3s ease 0s;
        }

        .form-horizontal .form-control:focus {
            box-shadow: none;
            outline: 0 none;
        }

        .form-horizontal .form-group label {
            padding: 0 20px;
            color: #7f8291;
            text-transform: capitalize;
            margin-bottom: 10px;
        }

        .form-horizontal .main-checkbox {
            width: 20px;
            height: 20px;
            background: #eec111;
            float: left;
            margin: 5px 0 0 20px;
            border: 1px solid #eec111;
            position: relative;
        }

        .form-horizontal .main-checkbox label {
            width: 20px;
            height: 20px;
            position: absolute;
            top: 0;
            left: 0;
            cursor: pointer;
        }

        .form-horizontal .main-checkbox label:after {
            content: "";
            width: 10px;
            height: 5px;
            position: absolute;
            top: 5px;
            left: 4px;
            border: 3px solid #fff;
            border-top: none;
            border-right: none;
            background: transparent;
            opacity: 0;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
        }

        .form-horizontal .main-checkbox input[type=checkbox] {
            visibility: hidden;
        }

        .form-horizontal .main-checkbox input[type=checkbox]:checked+label:after {
            opacity: 1;
        }

        .form-horizontal .text {
            float: left;
            font-size: 14px;
            font-weight: bold;
            color: #fff;
            margin-left: 7px;
            line-height: 20px;
            padding-top: 5px;
            text-transform: capitalize;
        }

        .form-horizontal .btn {
            width: 100%;
            background: #eec111;
            padding: 10px 20px;
            border: none;
            font-size: 14px;
            font-weight: bold;
            color: #fff;
            border-radius: 20px;
            text-transform: uppercase;
            margin: 20px 0 30px 0;
        }

        .form-horizontal .btn:focus {
            background: #eec111;
            color: #fff;
            outline: none;
            box-shadow: none;
        }

        @media only screen and (max-width: 479px) {
            .tab {
                padding: 40px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <div class="tab" role="tabpanel">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab"
                                data-toggle="tab">Вход</a></li>
                        <li role="presentation"><a href="#Section2" aria-controls="profile" role="tab"
                                data-toggle="tab">Регистрация</a></li>
                    </ul>
                    <div class="tab-content tabs">
                        <div role="tabpanel" class="tab-pane fade in active" id="Section1">
                            <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <div class="form-group">
                                    <label for="exampleInputLogin1">Логин</label>
                                    <input type="text" name="login" class="form-control" id="exampleInputLogin1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Пароль</label>
                                    <input type="password" name="password" class="form-control"
                                        id="exampleInputPassword1">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-default">Войти</button>
                                </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="Section2">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <a href="form.php" type="submit" class="btn btn-default">Перейти на форму
                                        регистрации</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $user = 'u52401'; // Заменить на ваш логин uXXXXX
                        $pass = '7321086'; // Заменить на пароль, такой же, как от SSH
                        $db = new PDO(
                            'mysql:host=localhost;dbname=u52401',
                            $user,
                            $pass,
                            [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                        );
                        $login = $_POST['login'];
                        $password = $_POST['password'];

                        $stmt = $db->prepare("SELECT * FROM users WHERE login = :login AND password = :password");
                        $stmt->bindParam(':login', $login);
                        $stmt->bindParam(':password', $password);

                        $stmt->execute();

                        if ($stmt->rowCount() > 0) {
                            echo '<div class="alert alert-success">Успешный вход в систему!<br>Добро пожаловать, '.$login.'</div>';
                        } else {
                            echo '<div class="alert alert-danger">Неверный логин или пароль!</div>';
                        }
                    }
                    ?>
                </div><!-- /.col-md-offset-3 col-md-6 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div>
</body>
