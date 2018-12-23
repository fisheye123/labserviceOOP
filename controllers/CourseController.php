<?php


class CourseController extends BaseController{
    
    
    function __construct($twig) {
        $this->userClass = new Course($_SESSION['course']);
        $this->twig = $twig;
    }
    
    /**
    * Загрузка главной страницы курса
    * 
    * @param object $twig - шаблонизатор
    */
    public function indexAction () {
        $tmpl = $this->myLoadTemplate('Course');
        $rsLabs = $this->userClass->ShowLabs();
        //Для отображения левого меню меобходимо достать список лабораторных
        //курса, в который мы вошли
        //
        //и передать его как 'rsLabs'
        
        echo $tmpl->render(array(
            'title' => $_SESSION['course']['title'],
            'rsLabs' => $rsLabs,
            'arCourse' => $_SESSION['course']
        ));
    }
    
    /**
    * Загрузка страницы лабораторной для студента и для преподавателя
    * 
    * @param object $twig - шаблонизатор
    */
   public function labAction () {
        $labId = filter_input(INPUT_GET, 'id');

        if (!$labId)
            $this->redirect();

        $rsLab = $this->userClass->ShowLabs($labId)[0];
        $title = "Лабораторная №{$rsLab['number']} - {$rsLab['title']}";
        $rsLabs = $this->userClass->ShowLabs();
        $rsStudents = $this->userClass->ShowStudents($labId);
        $tpppl = $this->myLoadTemplate('courseLab');
        echo $tpppl->render(array(
            'title' => $title,
            'rsLab' => $rsLab,
            'rsStudent' => $rsStudents,
            'rsLabs' => $rsLabs,
            'arCourse' => $_SESSION['course']
        ));
   }
    
   function uploadAction(){
        
        $myFile = $_FILES['file'];

        //Чистим строки
        $labId = filter_input(INPUT_GET, 'labId');
        $answer = filter_input(INPUT_GET, 'answer');
        $students = filter_input(INPUT_GET, 'stId');
        
        print_r($labId);
        
        $resData = $this->userClass->SetAnswer($labId, $answer, $students, $myFile);

        echo $resData;
    } 
}



/**
 * Загрузка страницы лабораторной для студента и для преподавателя
 * 
 * @param object $twig - шаблонизатор
 */
//function labAction ($twig) {
//    $labId = filter_input(INPUT_GET, 'id');
//    
//    if (!$labId) {
//        exit();
//    }
//    
//    $rsLab = getLabById($labId);
//    $title = "Лабораторная №{$rsLab['number']} - {$rsLab['title']}";
//    
//    if(isset($_SESSION['course'])) {
//        $rsLabs = getLabForCourse($_SESSION['course']['id']);
//        
//        $tpppl = myLoadTemplate($twig, 'CourseLab');
//        echo $tpppl->render(array(
//            'title' => $title,
//            'rsLab' => $rsLab,
//            'rsLabs' => $rsLabs,
//            'arCourse' => $_SESSION['course']
//        ));
//    } else {
//        redirect();
//    }
//}

