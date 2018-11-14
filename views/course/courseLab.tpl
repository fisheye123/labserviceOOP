{# Шаблон вывода лабораторной для студента #}

{% extends "CourseBase.tpl" %}

{% block content %}
    <h1 class="page__title">Лабораторная №{{ rsLab.number }} - {{ rsLab.title }}</h1>

    <div class="page__content">
        <form id="lab-form" class="lab-form">
            <div class="lab-form__wrapper lab-form__wrapper_top">{{ rsLab.task }}</div>
            <h3 class="lab-form__title">Отчёт</h3>
            <div class="lab-form__wrapper lab-form__wrapper_main">
                <div class="lab-form__wrapper lab-form__wrapper_left">
                    <label for="lab_answer" class="lab-form__item ">Ваш ответ:</label>
                    <label for="lab_students" class="lab-form__item">Выполнили:</label>
                </div>
                <div class="lab-form__wrapper lab-form__wrapper_right">
                    <textarea id="lab_answer" form="lab-form" class="lab-form__textarea"></textarea>
                    <input id="lab_students" class="lab-form__input" type="text">
                    
                    <form name="" enctype="multipart/form-data" method="post">
                        <!--<input type="hidden" name="MAX_FILE_SIZE" value="30000">-->
                        <input type="hidden" name="labId" id="labId" value="{{ rsLab.id }}">
                        <label class="file-label">
                            <span>Прикрепить файл</span>
                            <input name="file" id="file" type="file">
                        </label>

                        <button class="btn" onclick="uploadFile();">Отправить</button>
                    </form>
                    
                </div>
            </div>
        </form>
    </div>
{% endblock %}
