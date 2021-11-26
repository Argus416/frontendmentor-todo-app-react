const tasksList = document.querySelector(".tasks ul");
const todosLeft = document.querySelector(".todos-left");

const formTodo = document.querySelector("form.form-new-task");
const inputNewTodo = formTodo.querySelector(".input-new-task");

const clearTodos = document.querySelector(".clearTodosFromFinishedTodo");

const fetchdata = async () => {
    let response = await fetch("../data/db.json");
    if (response.status === 200) {
        // fetching data
        data = await response.text();
        data = JSON.parse(data);

        innerHtml(data);
        countTodos(data);

        AddTodo(data);
        clearTodosFromFinishedTodo(data);
        deletedTodo();
    } else {
        alert(response.status);
    }
};

function innerHtml(data) {
    tasksList.innerHTML = "";
    for (i = data.length - 1; i > 0; i--) {
        const completed = data[i].completed === true ? "label-text-active" : "";

        const todoTemplate = `
            <li class="task globalstyle" data-id="${data[i].id}">
                    <div class="left">
                        <input type="checkbox" id="checkbox2" />
                        <span class="custom-checkbox">
                            <span class="helper-custom-checkbox"></span>
                        </span>
                    </div>
                    <div class="text-container">
                            <span class="${completed} todo-text">${data[i].title}</span>
                        </div>
                    <div class="right">
                        <img src="style/images/icon-cross.svg" alt="" class="x" />
                    </div>
            </li>
        `;

        tasksList.innerHTML += todoTemplate;
    }
}

function countTodos(data) {
    const leftTodos = data.filter((todo) => todo.completed === false);
    todosLeft.innerHTML = leftTodos.length;
}

function AddTodo(data) {
    let id = parseInt(document.querySelector(".task").getAttribute("data-id")) + 1;

    formTodo.addEventListener("submit", function (e) {
        e.preventDefault();
        const todoText = inputNewTodo.value.trim();
        if (todoText.length) {
            const todo = {
                userId: id++,
                title: todoText,
                completed: false,
            };
            data.push(todo);
            tasksList.innerHTML = "";
            inputNewTodo.value = "";
            innerHtml(data);
            countTodos(data);
            clearTodosFromFinishedTodo(data);
            console.log(todo);
        } else {
            alert("Veuillez remplir le champ avant de soumettre");
        }
    });
}

function clearTodosFromFinishedTodo(data) {
    const finishedTodos = data.filter((todo) => todo.completed === false);
    clearTodos.addEventListener("click", function () {
        data = finishedTodos;
        innerHtml(data);
    });
}

function deletedTodo() {
    const todos = Array.from(document.querySelectorAll(".tasks ul li"));
    // console.log(todos);
    todos.forEach((element) => {
        // console.log(element);
    });
}

fetchdata();
