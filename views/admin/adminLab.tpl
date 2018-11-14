{% extends "adminBase.tpl" %}

{% block content %}
    <h1 class="page__title">Лабораторные</h1>
    
    <h2 class="page__title">Добавить лабораторную</h2>
    <div class="page__content">
        <form id="add-lab-form" class="add-lab-form">
            <div class="add-lab-form__wrapper add-lab-form__wrapper_main">
                <div class="add-lab-form__wrapper add-lab-form__wrapper_left">
                    <label for="lab_title" class="add-lab-form__item ">Название:</label>
                    <label for="lab_task" class="add-lab-form__item">Текст:</label>
                </div>
                <div class="add-lab-form__wrapper add-lab-form__wrapper_right">
                    <input type="text" id="lab_title" name="lab_title" value="">
                    <textarea id="lab_task" name="lab_task" form="add-lab-form" class="add-lab-form__textarea"></textarea>
                    <select id="lab_course" name="lab_course">
                        <option value="0">Выберите курс</option>
                        {% for course in rsCourses %}
                            <option value="{{ course.id }}">{{ course.title }}</option>
                        {% endfor %}
                    </select>
                    <button class="add-lab-form__button add-lab-form__button_file">Прикрепить файл</button>
                </div>
            </div>
            <input class="add-lab-form__button add-lab-form__button_submit" type="button" onclick="addLab();" value="Добавить">
        </form>
    </div>

<script>
    function run(id) {
        document.getElementById("labCourseId_" + id).value = document.getElementById("Ultra").value;
    }
</script>

    <h2 class="page__title">Лабораторные</h2>
    <div class="page__content">
        <!-- Пробуем таблицы. При желании потом изменить флекс-верстку -->
        <table border="1" cellpadding="1" cellspasing="1">
            <tr>
                <th>ID</th>
                <th>№</th>
                <th>Название</th>
                <th>Задание</th>
                <th>Вложение</th>
                <th>Доступ</th>
                <th>Курс</th>
                <th></th>
                <th></th>
            </tr>
            {% for lab in rsLab %}
                <tr>
                    <td>{{ lab.id }}</td>
                    <td>
                        <input type="edit" id="labNumber_{{ lab.id }}" value="{{ lab.number  }}">
                    </td>
                    <td>
                        <input type="edit" id="labTitle_{{ lab.id }}" value="{{ lab.title }}">
                    </td>
                    <td>
                        <input type="edit" id="labTask_{{ lab.id }}" value="{{ lab.task }}">
                    </td>
                    <td>
                        <input type="edit" id="labAttachment_{{ lab.id }}" value="{{ lab.attachment }}">
                    </td>
                    <td>
                        <input type="edit" id="labAccess_{{ lab.id }}" value="{{ lab.access }}">
                    </td>
                    <td>
                        <div id="lab-edit-test">
                        <select id="Ultra" name="labCourseId_{{ lab.id }}" onchange="run({{ lab.id }})">
                            {% for course in rsCourses %}
                                <option id="labCourseId_{{ lab.id }}" value="{{ course.id }}" {% if lab.course_id == course.id %} selected="selected"{% endif %}>{{ course.title }}</option>
                            {% endfor %}
                        </select>
                        </div>
                    </td>
                    <td>
                        <input type="button" value="Сохранить" onclick="updateLab({{ lab.id }})">
                    </td>
                    <td>
                        <input type="button" value="Удалить" onclick="deleteLab({{ lab.id }})">
                    </td>
                </tr>
            {% endfor %}
        </table>
                       
    </div>

{% endblock %}
