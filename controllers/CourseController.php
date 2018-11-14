<?php

/**
 * Загрузка главной страницы курса
 * 
 * @param object $twig - шаблонизатор
 */
function indexAction ($twig) {
    if (isset($_SESSION['Course'])) {
        $tmpl = myLoadTemplate($twig, 'course');
        echo $tmpl->render(array(
            'title' => $_SESSION['Course']['title'],
            'arCourse' => $_SESSION['Course']
        ));
    } else {
        redirect();
    }
}


/**
 * Загрузка страницы лабораторной для студента и для преподавателя
 * 
 * @param object $twig - шаблонизатор
 */
function labAction ($twig) {
    $labId = filter_input(INPUT_GET, 'id');
    
    if (!$labId) {
        exit();
    }
    
    $rsLab = getLabById($labId);
    $title = "Лабораторная №{$rsLab['number']} - {$rsLab['title']}";
    
    if(isset($_SESSION['course'])) {
        $rsLabs = getLabForCourse($_SESSION['course']['id']);
        
        $tpppl = myLoadTemplate($twig, 'CourseLab');
        echo $tpppl->render(array(
            'title' => $title,
            'rsLab' => $rsLab,
            'rsLabs' => $rsLabs,
            'arCourse' => $_SESSION['course']
        ));
    } else {
        redirect();
    }
}

