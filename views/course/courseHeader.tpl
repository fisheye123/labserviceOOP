<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ title }}</title>
    <meta charset="utf-8">
    <!-- Поправить линк. Нужно чтобы доставал через Twig TemplateWebPath -->
    <link rel="stylesheet" href="../www/css/course/course.css" type="text/css"/>
    <link rel="stylesheet" href="../www/css/main.css" type="text/css"/>
    <script src="../www/js/jquery-3.3.1.min.js"></script>
    <script src="../www/js/main.js"></script>
    <script src="../www/js/course/course.js"></script>
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <div class="user-block">
                {% if arCourse is defined %}
                    {{ arCourse['title'] }}<br />
                    <a href="?controller=Auth&action=logout" id="teacherLogoutImg">
                        <div class="exit">
                            <!-- Поправить линк. Нужно чтобы доставал через Twig TemplateWebPath -->
                            <img class="img" width="10" height="10" alt="Иконка 'Выход'" src="../www/sources/logout.svg"/>
                        </div>
                    </a>
                {% endif %}
            </div>
        </header>
        
        <main class="main-block">
            {% include "courseLeftColumn.tpl" %}
            <div class="page">