function addNewInfo(tableName) {
  // Создание объекта XMLHttpRequest
  var xhr = new XMLHttpRequest();

  // Определение обработчика события onload (загрузка завершена)
  xhr.onload = function () {
    if (xhr.status === 200) {
      var sendContainer = document.getElementById("sendContainer");
      sendContainer.innerHTML = xhr.responseText;
    } else {
      // Обработка ошибки
      console.log("Ошибка при выполнении запроса. Статус: " + xhr.status);
    }
  };

  // Отправка AJAX-запроса на сервер
  xhr.open("GET", "get_form.php?tableName=" + tableName, true);
  xhr.send();
}

function submitForm() {
  var xhr = new XMLHttpRequest();
  var activeElement = document.querySelector("a.active");
  xhr.open(
    "POST",
    "process_form.php?tableName=" + activeElement.innerText,
    true
  );
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      console.log(xhr.responseText);
      // Дополнительные действия после успешной отправки данных на сервер
    }
  };
  var formElement = document.getElementById("form");
  var formData = new FormData(formElement);
  var serializedData = new URLSearchParams(formData).toString();

  xhr.send(serializedData);
}

function userData(tableName) {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "get_table_data.php?tableName=" + tableName, true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      var response = xhr.responseText;
      var data = JSON.parse(response);
      var tableContainer = document.getElementById("statusContainer");
      var tableHTML = "<table id='table'>";
      tableHTML += "<thead><tr>";
      for (var i = 0; i < data.columns.length; i++) {
        tableHTML += "<th>" + data.columns[i] + "</th>";
      }
      tableHTML += "</tr></thead>";

      tableHTML += "<tbody>";
      for (var j = 0; j < data.rows.length; j++) {
        tableHTML += "<tr>";
        for (var k = 0; k < data.columns.length; k++) {
          tableHTML +=
            "<td><input type='text' value='" +
            data.rows[j][data.columns[k]] +
            "' id='" +
            data.rows[j][data.columns[0]] +
            "' name='" +
            data.columns[k] +
            "' disabled></td>"; // Вставляем поле в тег input с атрибутом disabled
        }
        tableHTML += "</td>";
        tableHTML += "</tr>";
      }
      tableHTML += "</tbody>";

      tableHTML += "</table>";

      tableContainer.innerHTML = tableHTML;
    } else {
      console.log("Ошибка при выполнении запроса. Статус: " + xhr.status);
    }
  };
  xhr.send();
}

function handleInfoChange(tableName) {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "get_table_data.php?tableName=" + tableName, true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      var response = xhr.responseText;
      var data = JSON.parse(response);
      var tableContainer = document.getElementById("tableContainer");
      var tableHTML = "<table id='table'>";
      tableHTML += "<thead><tr>";
      for (var i = 0; i < data.columns.length; i++) {
        tableHTML += "<th>" + data.columns[i] + "</th>";
      }
      tableHTML += "<th>Actions</th>"; // Добавлен столбец для действий
      tableHTML += "</tr></thead>";

      tableHTML += "<tbody>";
      for (var j = 0; j < data.rows.length; j++) {
        tableHTML += "<tr>";
        for (var k = 0; k < data.columns.length; k++) {
          tableHTML +=
            "<td><input type='text' value='" +
            data.rows[j][data.columns[k]] +
            "' id='" +
            data.rows[j][data.columns[0]] +
            "' name='" +
            data.columns[k] +
            "' disabled></td>"; // Вставляем поле в тег input с атрибутом disabled
        }
        tableHTML += "<td id='td" + data.rows[j][data.columns[0]] + "'>";
        tableHTML +=
          "<button onclick='editRecord(" +
          data.rows[j]["application_id"] +
          ")' id='editButton" +
          data.rows[j][data.columns[0]] +
          "'>Edit</button>"; // Кнопка редактирования
        tableHTML +=
          "<button onclick='deleteRecord(" +
          data.rows[j]["application_id"] +
          ")'>Delete</button>"; // Кнопка удаления
        tableHTML += "</td>";
        tableHTML += "</tr>";
      }
      tableHTML += "</tbody>";

      tableHTML += "</table>";

      tableContainer.innerHTML = tableHTML;
    } else {
      console.log("Ошибка при выполнении запроса. Статус: " + xhr.status);
    }
  };
  xhr.send();
}

function addInfo(tableName) {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "addInfo.php?tableName=" + tableName, true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      var response = xhr.responseText;
      document.getElementById("editContainer").innerHTML=response;
    } else {
      console.log("Ошибка при выполнении запроса. Статус: " + xhr.status);
    }
  };
  xhr.send();
}

function tableSearch() {
  var phrase = document.getElementById('filterInput');
  var table = document.getElementById('table');
  var regPhrase = new RegExp(phrase.value, 'i');
  var flag = false;
  for (var i = 1; i < table.rows.length; i++) {
      flag = false;
      for (var j = table.rows[i].cells.length - 1; j >= 0; j--) {
          flag = regPhrase.test(table.rows[i].cells[j].innerHTML);
          if (flag) break;
      }
      if (flag) {
          table.rows[i].style.display = "";
      } else {
          table.rows[i].style.display = "none";
      }

  }
}

// Функция для редактирования записи
function editRecord(recordId) {
  var inputFields = document.querySelectorAll('input[id="' + recordId + '"]');

  for (var i = 0; i < inputFields.length; i++) {
    inputFields[i].removeAttribute("disabled");
  }

  var saveButton = document.createElement("button");
  saveButton.textContent = "Сохранить";

  var editButton = document.getElementById("editButton" + recordId);
  editButton.disabled = true;

  saveButton.addEventListener("click", function () {
    saveChanges(recordId);
  });

  var editContainer = document.getElementById("td" + recordId);

  editContainer.appendChild(saveButton);
}

function saveChanges(recordId) {
  // Получить значения полей input после редактирования
  var inputFields = document.querySelectorAll('input[id="' + recordId + '"]');
  var formData = new FormData();

  // Перебрать поля input и добавить их значения в объект FormData
  for (var i = 0; i < inputFields.length; i++) {
    var fieldName = inputFields[i].name;
    var fieldValue = inputFields[i].value;
    formData.append(fieldName, fieldValue);
  }

  // Добавить идентификатор записи в объект FormData
  formData.append("recordId", recordId);

  // Выполнить отправку данных на сервер
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "save_changes.php", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Успешное сохранение изменений
        console.log(xhr.responseText);
        showSuccessMessage("Изменения сохранены.");
      } else {
        // Ошибка при сохранении изменений
        showErrorMessage("Ошибка при сохранении изменений.");
      }
    }
  };
  $a = "application";
  formData.append("table", $a);
  xhr.send(formData);
}

function showSuccessMessage(message) {
  // Создать элемент для отображения сообщения об успешном сохранении
  var successMessage = document.createElement("div");
  successMessage.textContent = message;
  successMessage.classList.add("success-message");
  successMessage.classList.add("mt-3");

  // Найти элемент, куда добавить сообщение
  var statusContainer = document.getElementById("statusContainer");

  // Добавить сообщение в элемент statusContainer
  statusContainer.appendChild(successMessage);

  // Обновить страницу через 3 секунды
  setTimeout(function () {
    location.reload();
  }, 1500);
}

function showErrorMessage(message) {
  // Создать элемент для отображения сообщения об ошибке
  var errorMessage = document.createElement("div");
  errorMessage.textContent = message;
  errorMessage.classList.add("error-message");

  // Найти элемент, куда добавить сообщение
  var statusContainer = document.getElementById("statusContainer");

  // Добавить сообщение в элемент statusContainer
  statusContainer.appendChild(errorMessage);
}

// Функция для удаления записи
function deleteRecord(recordId) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "delete_record.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var statusContainer = document.getElementById("statusContainer");
      console.log(xhr.responseText);
      statusContainer.innerHTML =
        '<div class="alert alert-success my-3" role="alert">Успешно удалено!</div>';
      setTimeout(function () {
        location.reload();
      }, 1500);
    }
  };
  $a = "application";
  xhr.send("id=" + recordId + "&table=" + $a);
}

document.addEventListener("DOMContentLoaded", function () {});
