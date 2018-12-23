<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Сейчас этот класс необходим для загрузки файла на сервер
class File{
    
    private $uploaddir = './attachments/';
    private $fileTypes =  array('pdf', 'png' ,'jpg');
    
    private $fileErr = null;
    private $file;
    
    //Возвращает имя файла
    public function SaveFile($file){
        $this->file = $file;
        $this->checkType();
        if ($this->fileErr !=  null)
            return null;
        $this->checkError();
        if ($this->fileErr !=  null)
            return null;
        $file_name = pathinfo($this->file['name'], PATHINFO_FILENAME); 
        $file_ext = pathinfo($this->file['name'], PATHINFO_EXTENSION); 
        $filename = $this->uploaddir . $file_name . 
                date('-m_d_Y-h_i_s_a', time()) . '.' . $file_ext;
        if (move_uploaded_file($this->file['tmp_name'], $filename)){
            return $filename; 
        }
    }
    
    public function GetError(){
        return $this->fileErr;
    }
    
    /**
    * Проверка на ошибки загрузки файла
    * 
    * @param array $file полученный файл
    * @return array массив
    */
   private function checkError () {
       $err = array();

       $errUpload = array( 
           0 => 'Ошибок не возникло, файл был успешно загружен на сервер. ', 
           1 => 'Размер принятого файла превысил максимально допустимый размер, который задан директивой upload_max_filesize конфигурационного файла php.ini. ', 
           2 => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE, указанное в HTML-форме. ', 
           3 => 'Загружаемый файл был получен только частично. ', 
           4 => 'Файл не был загружен. ', 
           6 => 'Отсутствует временная папка. ',
           7 => 'Не удалось записать файл на диск. ', 
           8 => 'PHP-расширение остановило загрузку файла. '
       );


       if ($this->file['error'] > 0) {
           $err[] = $errUpload[$this->file['error']];
       }

       if(!empty($err)) {
           $this->fileErr = implode(',', $err);
       }
   }

    /**
     * Проверка типа файла
     * 
     * @param array $file полученный файл
     * @return array массив
     */
    private function checkType () {
        $type = pathinfo($this->file['name'], PATHINFO_EXTENSION);
        if(!in_array($type, $this->fileTypes)) {
            $this->fileErr = 'Данный тип файла ' . $type . ' не подходит для загрузки! ';
        }
    }

    
}

