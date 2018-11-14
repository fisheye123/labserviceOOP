<nav class="menu">
    <ul class="menu__list">
        {% for lab in rsLabs %}
            {% if lab.access %}
                <li class="menu-list__sub-item"><a href="?controller=Course&action=lab&id={{ lab.id }}">{{ lab.title }}</a></li>
            {% endif %}
        {% endfor %}
    </ul>
</nav>