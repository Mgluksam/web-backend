document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form");
    form.addEventListener("submit", formSend);

    async function formSend(e) {
        e.preventDefault();
        let error = formValidate(form);
        if (error == 0) { // Если нет ошибок валидации
            $(function () { // Отправляем форму на formcarry.com
                var href = $(".ajaxForm").attr("action");
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: href,
                    data: $(".ajaxForm").serialize(),
                    success: function (response) {
                        if (response.status == "success") {
                            alert("Мы получили Вашу форму, благодарим за отправку!");
                            localStorage.clear();
                            let formReq = document.querySelectorAll(".checkReq"); // Поля, которые необходимо проверять
                            for (let index = 0; index < formReq.length; index++) {
                                formReq[index].value = "";
                            }
                            document.getElementById("FormCheck").checked = false;
                            document.getElementById("closeOrderButton").click();
                        } else {
                            alert("Непредвиденная ошибка: " + response.message);
                        }
                    }
                });
            });
        }
    }

    function formValidate(form) { // Проверка валидации формы
        let error = 0;
        let formReq = document.querySelectorAll(".checkReq"); // Поля, которые необходимо проверять
        for (let index = 0; index < formReq.length; index++) {
            const input = formReq[index];
            formRemoveError(input);
            if (input.id == "FormEmail") {
                if (emailTest(input)) {
                    formAddError(input);
                    error++;
                    console.log("email error");
                }
            } else if (input.getAttribute("type") === "checkbox" && input.checked === false) {
                formAddError(input);
                error++;
                console.log("check box error");
            } else {
                if (input.value === "") {
                    formAddError(input);
                    error++;
                    console.log("input value error");
                }
            }
        }
        return error;
    }

    function formAddError(input) { // Добавление класса error к элементу
        input.classList.add("error");
    }

    function formRemoveError(input) { // Удаление класса error к элементу
        input.classList.remove("error");
    }

    function emailTest(input) { // Функция проверки корректности введенного email
        const EMAIL_REGEXP = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/iu;
        return !EMAIL_REGEXP.test(input.value);
    }

    const inputs = document.querySelectorAll('input'); // Сохранение всех введенных в форму данных
    for (const input of inputs) {
        if (input.type != "checkbox") {
            input.value = localStorage[`input_${input.name}`] || '';
            input.addEventListener('change', function () {
                localStorage[`input_${this.name}`] = this.value;
            });
        }
    }

    let orderButton = document.getElementById("orderButton"); // History API
    orderButton.addEventListener('click', function (e) {
        state = {
            page: window.location.href + "/order"
        }
        history.pushState(state, "", state.page) // Объект состояния, описание, относительная ссылка
    });

    let closeOrder = document.getElementsByClassName("closeOrder");
    closeOrder[0].addEventListener('click', function (e) {
        window.history.back();
    });
    closeOrder[1].addEventListener('click', function (e) {
        window.history.back();
    });

    window.addEventListener('popstate', function (e) { // Обработчик нажатия вперед/назад пользователя
        document.getElementById("closeOrderButton").click();
        history.forward();
    });
});