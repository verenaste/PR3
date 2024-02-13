// JavaScript für das Umschalten der Sichtbarkeit erledigter To-Dos mit CSS-Klassen
document.getElementById('CompletedTodosButton').addEventListener('click', function() {
   //completedTodo aus function displaytodo
    var completedTodos = document.querySelectorAll('.completedTodo');
    var button = this;
    //durchläuft jedes Element in completedTodos
    completedTodos.forEach(function(todo) {
        //schaltet die CSS Klasse "hidden" ein
        todo.classList.toggle('hidden');
        button.textContent = todo.classList.contains('hidden') ? 'Alle To-Dos anzeigen' : 'Offene To-Dos anzeigen';
    });
});