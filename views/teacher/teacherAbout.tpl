{# Страница преподавателя #}

{% extends "teacherBase.tpl" %}

{% block content %}

    <h1 class="page__title">Мой профиль</h1>

    <div class="page__content">
        <!-- Пробуем таблицы. При желанию потом изменить флекс-верстку -->
        <div id="teacherDataForm">
            <table border="0">
                <tr>
                    <td>Логин:</td>
                    <td>{{ arTeacher['login'] }}</td>
                </tr>
                <tr>
                    <td>Имя:</td>
                    <td><input type="text" id="newName" name="name" value="{{ arTeacher['name'] }}"></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="text" id="newEmail" name="email" value="{{ arTeacher['email'] }}"></td>
                </tr>
                <tr>
                    <td>Новый пароль:</td>
                    <td><input type="password" id="newPassword1" name="password1" value=""></td>
                </tr>
                <tr>
                    <td>Повторите пароль:</td>
                    <td><input type="password" id="newPassword2" name="password2" value=""></td>
                </tr>
                <tr>
                    <td>Чтобы сохранить изменения введите текущий пароль:</td>
                    <td><input type="password" id="curPassword" name="curPassword" value=""></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type="button" onclick="updateTeacherData();" value="Сохранить изменения"></td>
                </tr>
            </table>
        </div>
                       
    </div>
            
{% endblock %}

