{# Шаблон вывода курса для студента #}

{% extends "teacherBase.tpl" %}

{% block content %}

    <h1 class="page__title">{{ rsCourse.title }}</h1>

    <div class="page__content">
        <form id="course-form" class="course-form">
            <div class="course-form__wrapper course-form__wrapper_description">{{ rsCourse.description }}</div>
            <div class="course-form__wrapper course-form__wrapper_labs">
                {% for lab in rsLabs %}
                    <ul class="menu-list">
                        <li class="menu-list__title"><a href="?controller=Teacher&action=lab&id={{ lab.id }}">Лабораторная №{{ lab.number }} - {{ lab.title }}</a></li>
                    </ul>                           
                {% endfor %}
                <a href="?controller=Teacher&action=labadd" class="button">Добавить лабораторную</a>
                <a href="?controller=Teacher&action=grade&id={{ rsCourse.id }}" class="button">Оценки за курс</a>
            </div>
        </form>  
    </div>
            
{% endblock %}
