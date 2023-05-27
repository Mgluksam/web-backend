<!DOCTYPE html>
<html lang="ru-RU">

<head>
  <?php
  include('style.php');
  include('isAuth.php');
  ?>

  <title>Practice</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script src="script.js"></script>
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container">
  <div class="d-flex justify-content-center align-items-center flex-column mx-5">
    <div class="text-center mt-3" id="sendContainer">
    </div>
    <div class="text-center mt-3" id="filterContainer">
      <label id="filterLabel">Фильтр по параметрам таблицы:</label>
      <input type='text' placeholder="Поиск" id='filterInput'>
    </div>
    <div class="text-center edit my-3" id="editContainer">
    </div>
    <div class="text-center mt-3" id="statusContainer">
    </div>
    <div class="text-center mt-3 pb-5" id="tableContainer">
    </div>
    
  </div>
</div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      handleInfoChange("application");
      userData("users");
      addInfo("application_ability");
      var filterInput = document.getElementById("filterInput");
      filterInput.addEventListener("keyup", tableSearch);
    });
  </script>
</body>

</html>