{% extends "adminBase.tpl" %}

{% block content %}
    <h1 class="page__title">Студенты</h1>
    
    <h2 class="page__title">Добавить студента</h2>
    <div class="page__content">
        <form id="add-student-form" class="add-student-form">
            <div class="add-student-form__wrapper add-student-form__wrapper_main">
                <div class="add-student-form__wrapper add-student-form__wrapper_left">
                    <label for="student_name" class="add-student-form__item ">Имя:</label>
                    <label for="student_group" class="add-student-form__item ">Группа:</label>
                </div>
                <div class="add-student-form__wrapper add-student-form__wrapper_right">
                    <input type="text" id="student_name" name="student_name" value="">
                    <input type="text" id="student_group" name="student_group" value="">
                </div>
            </div>
            <input class="add-student-form__button add-student-form__button_submit" type="button" onclick="addStudent();" value="Добавить">
        </form>
    </div>
    
    <h2 class="page__title">Студенты</h2>
    <div class="page__content">
        <!-- Пробуем таблицы. При желании потом изменить флекс-верстку -->
        <table border="1" cellpadding="1" cellspasing="1">
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Группа</th>
                <th></th>
                <th></th>
            </tr>
            {% for student in rsStudent %}
                <tr>
                    <td>{{ student.id }}</td>
                    <td>
                        <input type="edit" id="studentName_{{ student.id }}" value="{{ student.name  }}">
                    </td>
                    <td>
                        <input type="edit" id="studentGroup_{{ student.id }}" value="{{ student.learn_group }}">
                    </td>
                    <td>
                        <input type="button" value="Сохранить" onclick="updateStudent({{ student.id }})">
                    </td>
                    <td>
                        <input type="button" value="Удалить" onclick="deleteStudent({{ student.id }})">
                    </td>
                </tr>
            {% endfor %}
        </table>             
    </div>
{% endblock %}
