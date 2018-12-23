{% extends "teacherBase.tpl" %}

{% block content %}

    <h1 class="page__title">Общая таблица оценок курса {{rsCourse.title }}</h1>
    
    <div class="page__content">
        <h2 class="page__title">Оценки</h2>
        <div>
            {% if rsLab %}
                <table border="1" cellpadding="1" cellspasing="1">
                    <tr>
                        <th>Имя студента</th>
                        {% for lab in rsLab %}
                            <th>{{ lab.number }}</th>
                        {% endfor %}
                    </tr>
                    {% for student in rsStudents %}
                        <tr>
                            <td>
                                <label>{{ student.name }}</label>
                            </td>
                            {% for lab in rsLab %}
                                <td>
                                    <label>{{ student.labs[lab.id]}}</label>
                                </td>
                            {% endfor %}
                        </tr>
                    {% endfor %}
                </table>
            {% endif  %}
        </div>
            
    </div>
            
            
{% endblock %}
