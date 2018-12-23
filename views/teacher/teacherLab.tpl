{# Шаблон вывода лабораторной для студента #}

{% extends "teacherBase.tpl" %}

{% block content %}

    <h1 class="page__title">Лабораторная №{{ rsLab.number }} - {{ rsLab.title }}</h1>
    
    <div class="page__content">
        <form id="lab-form">
            <p class="taskDataForm">
                <label class="taskDataForm__left" >{{ rsLab.task }}</label>
            </p>
            
            <div class="lab-form__wrapper lab-form__checkbox">
                <label class="lab-form__checkbox_left" for="access">Видимость лабораторной: {{ rsLab.access }}</label>
            </div>
            
            {% if rsLab.attachment %}
                <label>Вложение:</label>
                <a href="{{ rsLab.attachment }}" download><img class="attachment" width="100" height="100" src="{{ rsLab.attachment }}" alt="Вложение"></a>
            {% endif %}
            
            <p>
                <input type="button" value="{{ rsLab.accessButton }}" onclick="updateLab({{ rsLab.id }})">
                <input type="button" value="Удалить" onclick="deleteLab({{ rsLab.id }})">
            </p>
        </form>
        
        
        <h2 class="page__title">Оценки</h2>
        <div>
            {% if rsExec %}
                <table border="1" cellpadding="1" cellspasing="1">
                    <tr>
                        <th>Группа</th>
                        <th>Имя</th>
                        <th>Ответ</th>
                        <th>Вложения</th>
                        <th>Оценка</th>
                    </tr>
                    {% for exec in rsExec %}
                        <tr>
                            <td>
                                <label>{{ exec.group }}</label>
                            </td>
                            <td>
                                <label>{{ exec.students }}</label>
                            </td>
                            <td>
                                <label>{{ exec.answer }}</label>
                            </td>
                            <td>
                                {% if exec.attachment %}
                                    <a href="{{ exec.attachment }}" download>Скачать</a>
                                {% endif %}
                            </td>
                            <td>
                                <input type="edit" id="execGrade_{{ exec.id }}" value="{{ exec.grade }}">
                            </td>
                            <td>
                                <input type="button" value="Оценить работу" onclick="setGrade({{ exec.id }})">
                            </td>
                        </tr>
                    {% endfor %}
                </table>
            {% else %}
                <label>В данный момент ни один студент не предоставил отчет о выполнении</label>
            {% endif  %}
        </div>
            
    </div>
            
            
{% endblock %}