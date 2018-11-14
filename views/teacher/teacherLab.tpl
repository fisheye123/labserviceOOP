{# Шаблон вывода лабораторной для студента #}

{% extends "base.tpl" %}

{% block content %}

    <h1 class="page__title">Лабораторная №{{ rsLab.number }} - {{ rsLab.title }}</h1>
    
    <div class="page__content">
        <form id="lab-form" class="lab-form">
            <div>{{ rsLab.task }}</div>
            <div>{{ rsLab.attachment }}</div>
            <div>Доступ: {{ rsLab.access }}</div>
        </form>
            
        <h2 class="page__title">Оценки</h2>
        <div>            
            <table border="1" cellpadding="1" cellspasing="1">
                <tr>
                    <th>Группа</th>
                    <th>Имя</th>
                    <th>Ответ</th>
                    <th>Вложения</th>
                    <th>Оценка</th>
                </tr>
                {% for student in rsStudents %}
                    <tr>
                        <td>
                            <input type="edit" value="{{ student.name }}">
                        </td>
                        <td>
                            <input type="edit" value="{{ student.learn_group }}">
                        </td>
                        <td>
                            <input type="edit" value="">
                        </td>
                        <td>
                            <input type="edit" value="">
                        </td>
                        <td>
                            <input type="edit" value="">
                        </td>
                    </tr>
                {% endfor %}
            </table>
            
        </div>
    </div>
            
            
{% endblock %}