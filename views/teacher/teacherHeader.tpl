<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ title }}</title>
    <meta charset="utf-8">
    <!-- Поправить линк. Нужно чтобы доставал через Twig TemplateWebPath -->
    <link rel="stylesheet" href="../www/css/teacher/teacher.css" type="text/css"/>
    <link rel="stylesheet" href="../www/css/main.css" type="text/css"/>
    <script src="../www/js/jquery-3.3.1.min.js"></script>
    <script src="../www/js/main.js"></script>
    <script src="../www/js/teacher/teacher.js"></script>
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <div class="user-block">
                {% if arTeacher is defined %}
                <a class="user-block__name" href="?controller=Teacher&action=about" >{{ arTeacher['name'] }}</a><br />
                    <a href="?controller=Auth&action=logout" id="teacherLogoutImg">
                        <div class="exit">
                            <!-- Поправить линк. Нужно чтобы доставал через Twig TemplateWebPath -->
                            <img class="img" width="10" height="10" alt="Иконка 'Выход'" src="../www/sources/logout.svg"/>
                        </div>
                    </a>
                {% endif %}
            </div>
            
            {% if crumbs is not empty %}
                <nav class="bread-crumbs">
                    <ul class="bread-crumbs__list">                               
                        {% for item in crumbs %}                
                            {% if item['url'] is not empty %}
                                <li class="bread-crumbs__item">
                                    {% if item['url'] is not empty %}
                                        <a href="{{ item['url'] }}">{{ item['text'] }}</a>
                                    {% else %}
                                        {{ item['text'] }}
                                    {% endif %}
                                </li>
                            {% endif %}
                        {% endfor %}
                    </ul>
                </nav>
            {% endif %}
        </header>
        
        <main class="main-block">
            {% include "teacherLeftColumn.tpl" %}
            <div class="page">