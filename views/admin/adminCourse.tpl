{% extends "adminBase.tpl" %}

{% block content %}
    <h1 class="page__title">Курсы</h1>
    
    <h2 class="page__title">Добавить курс</h2>
    <div class="page__content">
        <form id="add-course-form" class="add-course-form">
            <div class="add-course-form__wrapper add-course-form__wrapper_main">
                <div class="add-course-form__wrapper add-course-form__wrapper_left">
                    <label for="course_title" class="add-course-form__item ">Название:</label>
                    <label for="course_descripton" class="add-course-form__item">Описание:</label>
                    <label for="course_login" class="add-course-form__item ">Логин:</label>
                    <label for="course_password" class="add-course-form__item">Пароль:</label>
                </div>
                <div class="add-course-form__wrapper add-course-form__wrapper_right">
                    <input type="text" id="course_title" name="course_title" value="">
                    <textarea id="course_description" name="course_descripton" form="add-course-form" class="add-course-form__textarea"></textarea>
                    <input type="text" id="course_login" name="course_login" value="">
                    <input type="text" id="course_password" name="course_password" value="">
                </div>
            </div>
            <input class="add-course-form__button add-course-form__button_submit" type="button" onclick="addCourse();" value="Добавить">
        </form>
    </div>
    
    <h2 class="page__title">Курсы</h2>
    <div class="page__content">
        <!-- Пробуем таблицы. При желании потом изменить флекс-верстку -->
        <table border="1" cellpadding="1" cellspasing="1">
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Логин</th>
                <th>Пароль</th>
                <th></th>
                <th></th>
            </tr>
            {% for course in rsCourse %}
                <tr>
                    <td>{{ course.id }}</td>
                    <td>
                        <input type="edit" id="courseTitle_{{ course.id }}" value="{{ course.title  }}">
                    </td>
                    <td>
                        <input type="edit" id="courseDescription_{{ course.id }}" value="{{ course.description }}">
                    </td>
                    <td>
                        <input type="edit" id="courseLogin_{{ course.id }}" value="{{ course.login }}">
                    </td>
                    <td>
                        <input type="edit" id="coursePassword_{{ course.id }}" value="{{ course.password }}">
                    </td>
                    <td>
                        <input type="button" value="Сохранить" onclick="updateCourse({{ course.id }})">
                    </td>
                    <td>
                        <input type="button" value="Удалить" onclick="deleteCourse({{ course.id }})">
                    </td>
                </tr>
            {% endfor %}
        </table>        
    </div>
{% endblock %}
