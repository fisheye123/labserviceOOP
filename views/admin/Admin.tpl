{# Шаблон вывода главной страницы администратора #}
{% extends "adminBase.tpl" %}

{% block content %}
    <h1 class="page__title">Главная страница админки</h1>
    <div class="page__content">
        {% if arAdmin is defined %}
            {{ arAdmin['name'] }}<br />
        {% endif %}
    </div>
{% endblock %}
