<nav class="menu">
    <ul class="menu__list">
        <h1 class="menu-list__title">МОИ КУРСЫ</h1>
        {% for course in rsCourses %}
            <li class="menu-list__item"><a href="?controller=Teacher&action=course&id={{ course.id }}">{{ course.title }}</a>
                {% if course['lab'] is defined %}
                    <ul class="menu-list__submenu">
                        {% for lab in course['lab'] %}
                            <li class="menu-list__sub-item"><a href="?controller=Teacher&action=lab&id={{ lab.id }}">{{ lab.title }}</a></li>
                        {% endfor %}
                        <li class="menu-list__sub-item"><a href="?controller=Teacher&action=grade&id={{ course.id }}">Оценки за курс</a></li>
                    </ul>
                {% endif %}
            </li>
        {% endfor %}
    </ul>
</nav>        
