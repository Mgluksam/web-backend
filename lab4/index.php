<!DOCTYPE html>
<html lang="ru-RU">

<head>
  <title>lab4</title>
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
  <div class="container">
    <div class="row">
      <div class="form my-3">
        <div class="text-center">
          <h1 class="col mt-3" id="staticBackdropLabel">Форма</h5>
        </div>
        <div class="modal-body">
          <?php
          session_start();
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $flag = 1;
            $_SESSION['name'] = $_POST['name'];
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['text'] = $_POST['text'];
          }
          $name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
          $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
          $area = isset($_SESSION['text']) ? $_SESSION['text'] : '';
          if (strlen($name) <= 4) {
            $nameError = 'Имя должно содержать более 4 символов';
            $flag = 0;
          }
          if (preg_match('/\d/', $name)) {
            $nameError = 'К сожалению, цифр в имени быть не может =(';
            $flag = 0;
          }
          if (empty($email)) {
            $emailError = 'Пожалуйста, введите ваш email';
            $flag = 0;
          } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = 'Пожалуйста, введите корректный email';
            $flag = 0;
          }
          if (strlen($area) <= 10) {
            $areaError = "Биография должна содержать более 10 символов";
            $flag = 0;
          }
          if (!isset($_POST['check'])) {
            echo '<script>console.log("Чекбокс не был выбран.");</script>';
            $checkError = "Для отправки формы требуется согласие на обработку персональных данных";
            $flag = 0;
          }
          setcookie('nameError', $name, time() + (365 * 24 * 60 * 60));
          setcookie('emailError', $email, time() + (365 * 24 * 60 * 60));
          setcookie('textError', $area, time() + (365 * 24 * 60 * 60));

          if ($flag == 1) {
            echo '<div class="alert alert-success">Форма успешно отправлена!</div>';
            $name = $_POST['name'];
            $email = $_POST['email'];
            $born = $_POST['born'];
            $gender = $_POST['gender'];
            $radio = $_POST['num_of_limbs'];
            $abilities = $_POST['ability'];
            $text = $_POST['text'];
            $check = $_POST['check'];

            setcookie('nameError', $name, time() - (365 * 24 * 60 * 60));
            setcookie('emailError', $email, time() - (365 * 24 * 60 * 60));
            setcookie('textError', $area, time() - (365 * 24 * 60 * 60));

            setcookie('nameCorrect', $name, time() + (365 * 24 * 60 * 60));
            setcookie('emailCorrect', $email, time() + (365 * 24 * 60 * 60));
            setcookie('textCorrect', $area, time() + (365 * 24 * 60 * 60));
            
            $user = 'u52401'; // Заменить на ваш логин uXXXXX
            $pass = '7321086'; // Заменить на пароль, такой же, как от SSH
            $db = new PDO(
              'mysql:host=localhost;dbname=application',
              $user,
              $pass,
              [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            try {
              $stmt = $db->prepare("INSERT INTO application VALUES (null,:name,:email,:born,:gender,:num_of_limbs,:text)");
              $stmt->execute(['name' => $_POST['name'], 'email' => $_POST['email'], 'born' => $_POST['born'], 'gender' => $_POST['gender'], 'num_of_limbs' => $_POST['num_of_limbs'], 'text' => $_POST['text']]);
              $ap_id = $db->lastInsertId();
              foreach ($_POST['ability'] as $ab_id) {
                $stmt = $db->prepare("INSERT INTO application_ability VALUES (null,:ap_id,:ab_id)");
                $stmt->execute(['ap_id' => $ap_id, 'ab_id' => $ab_id]);
              }
            } catch (PDOException $e) {
              print('Error : ' . $e->getMessage());
              exit();
            }
          }

          session_destroy();
          ?>
          <form class="ajaxForm" id="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"
            accept-charset="UTF-8">
            <div class="col mb-3">
              <label for="InputName" class="form-label">Ваше имя без фамилии и отчества</label>
              <input type="text" name="name" value="<?php echo $name; ?>" class="form-control checkReq" id="FormName"
                aria-describedby="format" required />
              <?php
              if (isset($nameError)) {
                echo '<small style="margin-top:10px; color:red">' . $nameError . '</small>';
              }
              ?>
            </div>
            <div class="col mb-3">
              <label for="InputEmail1" class="form-label">Адрес электронной почты</label>
              <input type="email" name="email" value="<?php echo $email; ?>" class="form-control checkReq"
                id="FormEmail" aria-describedby="emailHelp" placeholder="name@example.com" />
              <?php
              if (isset($emailError)) {
                echo '<small style="margin-top:10px; color:red">' . $emailError . '</small>';
              }
              ?>
              <div id="emailHelp" class="form-text">
                Мы никогда никому не передадим вашу электронную почту.
              </div>
            </div>
            <div class="col mb-3">
              <div class="mb-3">
                <label for="year" class="form-label">Год рождения</label>
                <select name="born" class="form-select">
                  <option value="2023">2023 год</option>
                  <option value="2022">2022 год</option>
                  <option value="2021">2021 год</option>
                  <option value="2020">2020 год</option>
                  <option value="2019">2019 год</option>
                  <option value="2018">2018 год</option>
                  <option value="2017">2017 год</option>
                  <option value="2016">2016 год</option>
                  <option value="2015">2015 год</option>
                  <option value="2014">2014 год</option>
                  <option value="2013">2013 год</option>
                  <option value="2012">2012 год</option>
                  <option value="2011">2011 год</option>
                  <option value="2010">2010 год</option>
                  <option value="2009">2009 год</option>
                  <option value="2008">2008 год</option>
                  <option value="2007">2007 год</option>
                  <option value="2006">2006 год</option>
                  <option value="2005">2005 год</option>
                  <option value="2004">2004 год</option>
                  <option value="2003">2003 год</option>
                  <option value="2002">2002 год</option>
                  <option value="2001">2001 год</option>
                  <option value="2000">2000 год</option>
                  <option value="1999">1999 год</option>
                  <option value="1998">1998 год</option>
                  <option value="1997">1997 год</option>
                  <option value="1996">1996 год</option>
                  <option value="1995">1995 год</option>
                  <option value="1994">1994 год</option>
                  <option value="1993">1993 год</option>
                  <option value="1992">1992 год</option>
                  <option value="1991">1991 год</option>
                  <option value="1990">1990 год</option>
                  <option value="1989">1989 год</option>
                  <option value="1988">1988 год</option>
                  <option value="1987">1987 год</option>
                  <option value="1986">1986 год</option>
                  <option value="1985">1985 год</option>
                  <option value="1984">1984 год</option>
                  <option value="1983">1983 год</option>
                  <option value="1982">1982 год</option>
                  <option value="1981">1981 год</option>
                  <option value="1980">1980 год</option>
                  <option value="1979">1979 год</option>
                  <option value="1978">1978 год</option>
                  <option value="1977">1977 год</option>
                  <option value="1976">1976 год</option>
                  <option value="1975">1975 год</option>
                  <option value="1974">1974 год</option>
                  <option value="1973">1973 год</option>
                  <option value="1972">1972 год</option>
                  <option value="1971">1971 год</option>
                  <option value="1970">1970 год</option>
                  <option value="1969">1969 год</option>
                  <option value="1968">1968 год</option>
                  <option value="1967">1967 год</option>
                  <option value="1966">1966 год</option>
                  <option value="1965">1965 год</option>
                  <option value="1964">1964 год</option>
                  <option value="1963">1963 год</option>
                  <option value="1962">1962 год</option>
                  <option value="1961">1961 год</option>
                  <option value="1960">1960 год</option>
                  <option value="1959">1959 год</option>
                  <option value="1958">1958 год</option>
                  <option value="1957">1957 год</option>
                  <option value="1956">1956 год</option>
                  <option value="1955">1955 год</option>
                  <option value="1954">1954 год</option>
                  <option value="1953">1953 год</option>
                  <option value="1952">1952 год</option>
                  <option value="1951">1951 год</option>
                  <option value="1950">1950 год</option>
                  <option value="1949">1949 год</option>
                  <option value="1948">1948 год</option>
                  <option value="1947">1947 год</option>
                  <option value="1946">1946 год</option>
                  <option value="1945">1945 год</option>
                  <option value="1944">1944 год</option>
                  <option value="1943">1943 год</option>
                  <option value="1942">1942 год</option>
                  <option value="1941">1941 год</option>
                  <option value="1940">1940 год</option>
                  <option value="1939">1939 год</option>
                  <option value="1938">1938 год</option>
                  <option value="1937">1937 год</option>
                  <option value="1936">1936 год</option>
                  <option value="1935">1935 год</option>
                  <option value="1934">1934 год</option>
                  <option value="1933">1933 год</option>
                  <option value="1932">1932 год</option>
                  <option value="1931">1931 год</option>
                  <option value="1930">1930 год</option>
                  <option value="1929">1929 год</option>
                  <option value="1928">1928 год</option>
                  <option value="1927">1927 год</option>
                  <option value="1926">1926 год</option>
                  <option value="1925">1925 год</option>
                  <option value="1924">1924 год</option>
                  <option value="1923">1923 год</option>
                  <option value="1922">1922 год</option>
                  <option value="1921">1921 год</option>
                  <option value="1920">1920 год</option>
                  <option value="1919">1919 год</option>
                  <option value="1918">1918 год</option>
                  <option value="1917">1917 год</option>
                  <option value="1916">1916 год</option>
                  <option value="1915">1915 год</option>
                  <option value="1914">1914 год</option>
                  <option value="1913">1913 год</option>
                  <option value="1912">1912 год</option>
                  <option value="1911">1911 год</option>
                  <option value="1910">1910 год</option>
                  <option value="1909">1909 год</option>
                  <option value="1908">1908 год</option>
                  <option value="1907">1907 год</option>
                  <option value="1906">1906 год</option>
                  <option value="1905">1905 год</option>
                  <option value="1904">1904 год</option>
                  <option value="1903">1903 год</option>
                  <option value="1902">1902 год</option>
                  <option value="1901">1901 год</option>
                  <option value="1900">1900 год</option>
                </select>
              </div>
            </div>
            <div class="col mb-3">
              <label class="form-label">Пол</label>
              <select class="form-select" aria-label="Пример выбора по умолчанию" name="gender">
                <option value="1">М</option>
                <option value="2">Ж</option>
              </select>
            </div>
            <div class="col"><label for="FormControlTextarea1" class="form-label">Кол-во конечностей</label></div>
            <div class="col mb-3 ml-2">
              <div class="form-check">
                <input class="form-check-input" checked type="radio" name="num_of_limbs" id="Radio1" value="1">
                <label class="form-check-label" for="flexRadioDefault1">
                  2
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="num_of_limbs" id="Radio2" value="2">
                <label class="form-check-label" for="flexRadioDefault2">
                  4
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="num_of_limbs" id="Radio3" value="3">
                <label class="form-check-label" for="flexRadioDefault3">
                  6
                </label>
              </div>
            </div>
            <div class="col mb-3">
              <label for="FormControlTextarea1" class="form-label">Сверхспособности</label>
              <select class="form-select" name="ability[]" aria-label="Пример выбора по умолчанию" multiple>
                <option selected value="1">Бессмертие</option>
                <option value="2">Прохождение сквозь стены</option>
                <option value="3">Левитация</option>
              </select>
            </div>
            <div class="col mb-3">
              <label for="FormControlTextarea1" class="form-label">Биография</label>
              <textarea class="form-control checkReq" name="text" id="FormTextarea"
                rows="3"><?php echo $area; ?></textarea>
              <?php
              if (isset($areaError)) {
                echo '<small style="margin-top:10px; color:red">' . $areaError . '</small>';
              }
              ?>
            </div>
            <div class="col mb-3 ml-3 form-check">
              <input type="checkbox" class="form-check-input checkReq" name="check" id="FormCheck" />
              <label class="form-check-label" for="exampleCheck1">Ознакомлен(-а)</label>
              <?php
              if (isset($checkError)) {
                echo '<br/><small style="margin-top:10px; color:red">' . $checkError . '</small>';
              }
              ?>
            </div>
            <div class="col"><button type="submit" id="submitButton" class="btn btn-primary">Отправить</button></div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
</body>

</html>
