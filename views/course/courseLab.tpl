{# Шаблон вывода лабораторной для студента #}

{% extends "CourseBase.tpl" %}

{% block content %}
    <h1 class="page__title">Лабораторная №{{ rsLab.number }} - {{ rsLab.title }}</h1>

    <div class="page__content">
        <form id="lab-form" class="lab-form">
            <div class="lab-form__wrapper lab-form__wrapper_top">{{ rsLab.task }}</div>
            {% if rsLab.attachment %}
                <label>Вложение:</label>
                <a href="{{ rsLab.attachment }}" download><img class="attachment" width="100" height="100" src="{{ rsLab.attachment }}" alt="Вложение"></a>
            {% endif %}
            <h3 class="lab-form__title">Отчёт</h3>
            <div class="lab-form__wrapper lab-form__wrapper_main">
                <div class="lab-form__wrapper lab-form__wrapper_left">
                    <label for="lab_answer" class="lab-form__item ">Ваш ответ:</label>
                    </br> </br> 
                    <label for="lab_students" class="lab-form__item">Выполнили:</label>
                </div>
                <div class="lab-form__wrapper lab-form__wrapper_right">
                    
                    <form name="" enctype="multipart/form-data" method="post">
                        <input type="hidden" name="labId" id="labId" value="{{ rsLab.id }}">
                        <textarea id="lab_answer" form="lab-form" class="lab-form__textarea"></textarea>
                        
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
                        
                        {% for student in rsStudent %}  
                            <div class="lab-form__wrapper lab-form__checkbox">
                                <input class="lab-form__checkbox_left" type="checkbox" id="hz" {{student.state}} name="stId" value="{{ student.id }}">
                                <label class="lab-form__checkbox_right" for="stId">{{ student.name }}</label>
                            </div>
                        {% endfor %}   
                        <input type="hidden" name="stId-list" value="">
                        
                        <script>
                        $(document).on('click', 'input[name="stId"]', function(){
                          $('input[name="stId-list"]').val(
                            $('input[name="stId"]:checked')
                            .map(function(){
                              return this.getAttribute('value');
                            })
                            .get()
                          );
                        });
                        </script>

                        <button class="btn" onclick="uploadFile();">Отправить</button>
                    </form>
                    
                </div>
            </div>
        </form>
    </div>
{% endblock %}
