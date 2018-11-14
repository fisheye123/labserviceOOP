{# Шаблон вывода главной страницы преподавателя #}
{% extends "teacherBase.tpl" %}

{% block content %}
    <h1 class="page__title">Главная страница преподавателя</h1>  
    <div class="page__content">
        {% if arTeacher is defined %}
            {{ arTeacher['name'] }}<br />
        {% endif %}
    </div>
{% endblock %}
