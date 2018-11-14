/**
 * Обновление данных преподавателя
 * 
 */
function updateTeacherData() {
    var postData = getData('#teacherDataForm');
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "?controller=Teacher&action=update",
        data: postData,
        dataType: 'text',
        success: function(data){
            var jsonData = JSON.parse(data);
            $('#teacherLink').html(jsonData['teacherName']);
            console.log(jsonData);
            alert(jsonData['message']);
        }
    });
}

/**
 * Добавление лабораторной
 * 
 */
function addLab() {
    var postData = getData('#add-lab-form');
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "?controller=Teacher&action=addlab",
        data: postData,
        dataType: 'text',
        success: function(data){
            var jsonData = JSON.parse(data);
            alert(jsonData['message']);
            console.log(jsonData['message']);
            if (jsonData['success']) {
                window.location.reload();
            }
        },
        error: function (xhr, ajaxOptions, thrownError, data) {
            console.log(data);
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

/**
 * Изменение данных лабораторной
 * 
 * @param {integer} id
 */
function updateLab(id) {
    var newNumber = $('#labNumber_' + id).val();
    var newTitle = $('#labTitle_' + id).val();
    var newTask = $('#labTask_' + id).val();
    var newAccess = $('#labAccess_' + id).val();
    var newCourse_id = $('#labCourseId_' + id).val(); 
    /* Альтернативный вариант:
    var e = document.getElementById('labCourseId_' + labId);
    var newCourse_id = e.value;*/
    
    var postData = {labId: id, newNumber: newNumber, 
                    newTitle: newTitle, newTask: newTask, newAccess: newAccess,
                    newCourse_id: newCourse_id};
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "?controller=Teacher&action=updatelab",
        data: postData,
        dataType: 'text',
        success: function(data){
            var jsonData = JSON.parse(data);
            alert(jsonData['message']);
            console.log(jsonData['message']);
        },
        error: function (xhr, ajaxOptions, thrownError, data) {
            console.log(data);
            alert(xhr.status);
            alert(thrownError);
        }
    });
};

/**
 * Удаление лабораторной
 * 
 * @param {integer} id
 */
function deleteLab(id) {
    var postData = {id: id};
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "?controller=Teacher&action=deletelab",
        data: postData,
        dataType: 'text',
        success: function(data){
            var jsonData = JSON.parse(data);
            alert(jsonData['message']);
            console.log(jsonData['message']);
            window.location.reload();
        },
        error: function (xhr, ajaxOptions, thrownError, data) {
            console.log(data);
            alert(xhr.status);
            alert(thrownError);
        }
    });
};

/**
 * Показывает или скрывает лабораторные курса в левом меню
 * 
 */
function showLab() {
    if( $("#labHidden").css('display') != 'block' ) {
        $("#labHidden").show();
    } else {
        $("#labHidden").hide();
    }
}
