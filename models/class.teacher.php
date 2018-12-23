<?php

require_once 'class.file.php';

class Teacher extends Unit{
    
    // Массив info:
    // name
    // email
    // login
    // password
    protected $info = array();
    
    //TODO: Расширить правила для дубликатов
    protected $duplicateFields = array('name', 'email', 'login');
    protected $duplicateOperator = 'or';
    protected $ClassFactory;
    
    /**
     * Конструктор
     * @param array $info - информация об объекте из БД
     */
    function __construct(array $info = null, $facrory = null){
        if ($facrory === null){
            $this->ClassFactory = new Factory();
        } else {
            $this->ClassFactory = $facrory;
        }
        // Если info пустое, то наш объект - пустышка, необходимая
        // для инициализации объекта в БД. То бишь, будет вызвана 
        // функция SelfCreate
        if ($info != null){
            $this->SetInfo($info);
        }
    }
    
    protected function SetInfo($info){
        $info = array_values($info);
        $this->id = $info[0];
        $this->info['name'] = $info[1];
        $this->info['email'] = $info[2];
        $this->info['login'] = $info[3];
        $this->info['password'] = $info[4];
    }
    
    protected function UpdateInfo($info){
        $info = array_values($info);
        $this->info['name'] = $info[0];
        $this->info['email'] = $info[1];
        $this->info['login'] = $info[2];
        $this->info['password'] = $info[3];
    }
    
    public function GetCourses($courseId = null){
        //Здесь новый паттерн нужен, пока не придумала какой
        //пока что работаем с БД ручками
        $this->SQLBase = DBSQL::GetInstance();
        $this->SQLBase->SetWhere(array('teacher_id' => $this->id));
        $this->SQLBase->select('*', 'teacher_course');
        $result = $teacherCoursesId = $this->SQLBase->GetLastResult();
        if (!$result)
            return null;
        $resultId = array();
        foreach ($teacherCoursesId as $courseInfo){
            array_push($resultId, $courseInfo['course_id']);
        }
        
        if ($courseId){
            $isCourseFinded = false;
            foreach ($resultId as $key => $id){
                if ($courseId == $id){
                    unset($resultId);
                    $resultId = array($courseId);
                    $isCourseFinded = true;
                }
            }
            if (!$isCourseFinded)
                return null;
        }
        
        $resultCourse = array();
        $conditions = array();
        foreach ($resultId as $key => $id){
            $conditions['id'] = $id;
            array_push($resultCourse,
                    $this->ClassFactory->GetObjects('course', $conditions)[0]);
        }
        return $resultCourse;
    }
    
    //Немного неадекватно получилось, надо придумать более эргономичное решение
    //Времени нет, так что пока так
    public function GetStudents($courseId){
        //Здесь новый паттерн нужен, пока не придумала какой
        //пока что работаем с БД ручками
        $this->SQLBase = DBSQL::GetInstance();
        $this->SQLBase->SetWhere(array('course_id' => $courseId));
        $result = $this->SQLBase->select('*', 'student_course');
        if (!$result)
            return null;
        
        $studentsId = $this->SQLBase->GetLastResult();
        $resultId = array();
        foreach ($studentsId as $studentInfo){
            array_push($resultId, $studentInfo['student_id']);
        }
        
        $resultCourse = array();
        $conditions = array();
        foreach ($resultId as $key => $id){
            $conditions['id'] = $id;
            array_push($resultCourse,
                    $this->ClassFactory->GetObjects('student', $conditions)[0]);
        }
        return $resultCourse;
    }


    public function ShowCourses($courseId = null, $withLab = true ){
        
        $resultCourse = $this->GetCourses($courseId);
        
        if ($resultCourse == null)
           return null;
        
        $resultCourseInfo = array();
        foreach ($resultCourse as $course){
            $infoArray = $course->GetInfo();
            if ($withLab)
                $infoArray['lab'] = $course->ShowLabs(null, false);
            array_push($resultCourseInfo, $infoArray);
        }
        
        return $resultCourseInfo;
    }
    
    public function SelfUpdateEx($name, $email, $pass, $curPass){
        
        if (!$this->CheckEmptyParams(array($name, $email, $curPass))){
            $resData['success'] = 0;
            $resData['message'] = 
                    'Ошибка обновления профиля. Обязательные поля не заполнены';
            return $resData;
        }
        
        if ($curPass != $this->info['password']){
            $resData['success'] = 0;
            $resData['message'] = 'Текущий пароль введен неверно';
            return $resData;
        }
        
        $myNewInfo = array();
        $myNewInfo["name"] = $name;
        $myNewInfo["email"] = $email;
        $myNewInfo["login"] = $this->info['login'];
        if (!$pass)
            $myNewInfo["password"] = $this->info['password'];
        else
            $myNewInfo["password"] = $pass;
        
        $rs = $this->SelfUpdate($myNewInfo);
        
        if (!$rs){
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка обновления профиля.';
            return $resData;
        }
        $resData['success'] = 1;
        $resData['message'] = 'Профиль обновлен.';
            
        return $resData;
    }
    
    public function CreateLab($title, $task, $courseId, $labFile = null){
        if (!$this->CheckEmptyParams(array($title, $courseId))){
            $res['success'] = FALSE;
            $res['message'] = "Обязательные поля не заполнены";
            return $res;
        }
        
        $labCourseInfo = array('course_id' => $courseId);
        $labCourse = $this->ClassFactory->GetObjects('lab', $labCourseInfo);
        $labNumber = -1;
        foreach ($labCourse as $lab){
            $info = $lab->GetInfo();
            if ($info['number'] > $labNumber){
                $labNumber = $info['number'];
            }
        }
        $labNumber += 1;
        
        $filename = null;
        if ($labFile['size'] != 0){
            $file = new File();
            $filename = $file->SaveFile($labFile);
            if (!$filename){
                return $file->GetError();
            }
        }
        
        $newLab = $this->ClassFactory->GetBlankObject('lab');
        
        $labInfo = array();
        $labInfo['number'] = $labNumber;
        $labInfo["title"] = $title;
        $labInfo["task"] = $task;
        $labInfo['attachment'] = $filename;
        $labInfo['access'] = 0;
        $labInfo["course_id"] = $courseId;

        $rs = $newLab->SelfCreate($labInfo);
        
        if (!$rs){
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка добавления лабораторной работы';
            return $resData;
        }
        
        $resData['message'] = 'Лабораторная работа добавлена';
        $resData['success'] = 1;
        return $resData;
    }
    
    public function ShowLab($condition = null){
        $resultLabInfo = array(); 
        $resultLab = $this->ClassFactory->GetObjects('lab', $condition);
        foreach ($resultLab as $lab){
            $tempLabInfo = $lab->GetInfo();
            if ($tempLabInfo['access'] == true){
                $tempLabInfo['access'] = 'открыта';
                $tempLabInfo['accessButton'] = 'Закрыть лабораторную работу';
            }
            else{
                $tempLabInfo['access'] = 'закрыта';
                $tempLabInfo['accessButton'] = 'Открыть лабораторную работу';
            }
            array_push($resultLabInfo, $tempLabInfo);
        }
        return $resultLabInfo;
    }
    
    public function ShowExec($labId){
        $resultExec = array();
        $this->SQLBase->SetWhere(array("lab_id" => $labId));
        $rs = $this->SQLBase->select('id', 'lab_exec');
        if (!$rs)
            return null;
        foreach ($this->SQLBase->GetLastResult() as $key => $result){
            $lrs = new LabResult($result['id']);
            array_push($resultExec, $lrs->GetInfo());
        }
        return $resultExec;
    }
    
    public function SetGrade($execId, $grade){
        if (!$this->CheckEmptyParams(array($execId, $grade))){
            $res['success'] = FALSE;
            $res['message'] = "Обязательные поля не заполнены";
            return $res;
        }
        
        $lrs = new LabResult($execId);
        $rs = $lrs->SetGrade($grade);
        if (!$rs){
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка выставления оценки.';
            return $resData;
        }
        $resData['success'] = 1;
        $resData['message'] = 'Оценка выставлена.';
            
        return $resData;
    }
    
    public function EditLab($labId){
        
        $currentLabInfo = array("id" => $labId);
        $labForEdit = $this->ClassFactory->GetObjects('lab', $currentLabInfo)[0];
        
        //Есть специализированные проверки для лабораторных работ!
        $newLabInfo = $labForEdit->GetInfo();
        unset($newLabInfo['id']);
        if ($newLabInfo['access'] != 0)
            $newLabInfo['access'] = 0;
        else
            $newLabInfo['access'] = 1;
        
        $rs = $labForEdit->SelfUpdate($newLabInfo);
        
        if(!$rs) {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка изменения данных лабораторной работы';
            return $resData;
        }
        $resData['success'] = 1;
        $resData['message'] = "Данные лабораторной работы обновлены";
        return $resData;   
    }
    
    /**
     * Удаление лабораторной работы
     * @param int $id - id лабораторной
     * @return array[boolean,string] - результат выполнения операции и комментарий
     */
    public function DeleteLab($id){
        
        $labInfo = array();
        $labInfo["id"] = $id;
        $labForDelete = $this->ClassFactory->GetObjects('lab', $labInfo)[0];
        $rs = $labForDelete->SelfDelete();
        if (!$rs) {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка удаления лабораторной работы';
            return $resData;
        }
        
        $resData['success'] = 1;
        $resData['message'] = 'Лабораторная работа удалена';
        return $resData;
    }
    
    
    //TODO: Слишком узкое решение. Переделать обязательно!!!
    public function ShowStudent($courseId){ 
        
        $resultStudent = $this->GetStudents($courseId);
        
        
        if ($resultStudent == null)
           return null;
        
        $resultStudentInfo = array();
        foreach ($resultStudent as $student){
            $infoArray = $student->GetInfo();
            array_push($resultStudentInfo, $infoArray);
        }
        
        return $resultStudentInfo;
    }
    
    
    //Эх, функция эта писалась с тяжелым сердцем, и вот почему
    //Система так устроена, что таблицу с оценками каждого ученика 
    //сложно вывести - прямой связи между объектами 
    //студент - лабораторная - оценка нет. Нужно было идти окольными путями
    //При вызове функции выполняется огромное количество запросов.
    //Она остается такой по одной причине - малое количество преподавателей.
    //TODO: оптимизация!
    public function ShowStudentsWithGrade($courseId){
        $resStudents = array();
        
        $this->SQLBase->SetWhere(array('course_id' => $courseId));
        $rs = $this->SQLBase->select('student_id', 'student_course');
        if (!$rs)
            return null;
        $condForStudent = array('id' => array());
        foreach ($this->SQLBase->GetLastResult() as $key => $result){
            array_push($condForStudent['id'], $result['student_id']);
        }
        
        $students = $this->ClassFactory->GetObjects('student', $condForStudent, "or");
        $labs = $this->ClassFactory->GetObjects('lab', array('course_id' => $courseId));
        for ($i = 0; $i < count($students);$i++){
           $labGrade = array();
           $studentInfo = $students[$i]->GetInfo();
           $this->SQLBase->SetWhere(array('student_id' => $studentInfo['id']));
           $rs = $this->SQLBase->select('*', 'student_lab_exec');
           foreach($this->SQLBase->GetLastResult() as $labsInfo){
               $this->SQLBase->SetWhere(array('id' => $labsInfo['lab_exec_id']));
               $rs = $this->SQLBase->select('lab_id', 'lab_exec');
               $labGrade[$this->SQLBase->GetLastResult()[0]['lab_id']] = 
                       $labsInfo['mark']; 
           }
           $resStudents[$i]['labs'] = $labGrade;
           $resStudents[$i]['name'] = $studentInfo['name'];
        }
        return $resStudents;
        
    }
}

