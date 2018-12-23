{# Шаблон вывода добавления лаборатоной для преподавателя #}

{% extends "teacherBase.tpl" %}

{% block content %}

    <h1 class="page__title">Добавить лабораторную</h1>
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
                            <option id="course_id" value="{{ course.id }}">{{ course.title }}</option>
                        {% endfor %}
                    </select>
                    
                    <div class="file-form-wrap">
                        <div class="file-upload">
                            <label class="file-label">
                                <input id="file" type="file" name="file" onchange="getFileParam();" />
                                <span>Выберите файл</span><br />
                            </label>
                        </div>
                        <div id="preview1">&nbsp;</div>
                        <div id="file-name1">&nbsp;</div>
                        <div id="file-size1">&nbsp;</div>
                    </div>
                </div>
            </div>
                    
            <button onclick="addLab();">Отправить</button>
        </form>
    </div>

{% endblock %}
