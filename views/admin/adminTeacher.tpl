{% extends "adminBase.tpl" %}

{% block content %}
    <h1 class="page__title">Преподаватели</h1>
    
    <h2 class="page__title">Зарегистрировать преподавателя</h2>
    <div class="page__content">
        <form id="register-form" class="register-form">
            <div class="register-form__wrapper register-form__wrapper_main">
                <div class="register-form__wrapper register-form__wrapper_left">
                    <label for="name" class="register-form__item ">Имя:</label>
                    <label for="email" class="register-form__item">E-mail:</label>
                    <label for="login" class="register-form__item ">Логин:</label>
                    <label for="password" class="register-form__item">Пароль:</label>
                </div>
                <div id="registerBox" class="register-form__wrapper register-form__wrapper_right">
                    <input type="text" id="name" name="name" value="">
                    <input type="text" id="email" name="email" value="">
                    <input type="text" id="login" name="login" value="">
                    <input type="text" id="password" name="password" value="">
                </div>
            </div>
            <input class="register-form__button register-form__button_submit" type="button" onclick="addTeacher();" value="Зарегистрировать"><br>
        </form>
    </div>
    
    <h2 class="page__title">Преподаватели</h2>
    <div class="page__content">
        <!-- Пробуем таблицы. При желании потом изменить флекс-верстку -->
        <table border="1" cellpadding="1" cellspasing="1">
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Логин</th>
                <th>Пароль</th>
                <th>Курсы</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            {% for teacher in rsTeacher %}
                <tr>
                    <td>{{ teacher.id }}</td>
                    <td>
                        <input type="edit" id="teacherName_{{ teacher.id }}" name="teacherName_{{ teacher.id }}" value="{{ teacher.name  }}">
                    </td>
                    <td>
                        <input type="edit" id="teacherEmail_{{ teacher.id }}" name="teacherEmail_{{ teacher.id }}" value="{{ teacher.email }}">
                    </td>
                    <td>
                        <input type="edit" id="teacherLogin_{{ teacher.id }}" name="teacherLogin_{{ teacher.id }}" value="{{ teacher.login }}">
                    </td>
                    <td>
                        <input type="edit" id="teacherPassword_{{ teacher.id }}" name="teacherPassword_{{ teacher.id }}" value="{{ teacher.password }}">
                    </td>
                    <td>
                        <select multiple name="">
                            {% for course in rsCourses %}
                                {% for courseInTeach in teacher.courses %} 
                                    {% if courseInTeach.course_id == course.id %}
                                        <option value="{{ course.id }}">{{ course.title }}</option>
                                    {% endif %}
                                {% endfor %}
                            {% endfor %}
                        </select>
                    </td>
                    <td>
                        <a href="/admin/courses/?teacherid={{ teacher.id }}" class="button" name="id">Изменить курсы</a>
                    </td>
                    <td>
                        <input type="button" value="Сохранить" onclick="updateTeacher({{ teacher.id }})">
                    </td>
                    <td>
                        <input type="button" value="Удалить" onclick="deleteTeacher({{ teacher.id }})">
                    </td>
                </tr>
            {% endfor %}
        </table>             
    </div>
{% endblock %}
