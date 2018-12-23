{# Шаблон вывода главной страницы курса #}
{% extends "CourseBase.tpl" %}

{% block content %}
    <h1 class="page__title">Главная страница курса (студента)</h1>
    <h3>djksfjkfdkj ;ldfk ;l</h3>
    <div class="page__content">
        {% if arCourse is defined %}
            {{ arCourse['title'] }}<br />
        {% endif %}
    </div>
{% endblock %}
