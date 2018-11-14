{# Шаблон вывода добавления лаборатоной для преподавателя #}

{% extends "base.tpl" %}

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
                            <option value="{{ course.id }}">{{ course.title }}</option>
                        {% endfor %}
                    </select>
                    <button class="add-lab-form__button add-lab-form__button_file">Прикрепить файл</button>
                </div>
            </div>
            <input class="add-lab-form__button add-lab-form__button_submit" type="button" onclick="addLab();" value="Добавить"><br>
        </form>
    </div>

{% endblock %}
