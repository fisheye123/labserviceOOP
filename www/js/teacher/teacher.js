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
            window.location.reload();
        }
    });
}

/**
 * Добавление лабораторной
 * 
 */
function addLab11() {
    var postData = getData('#add-lab-form');
    console.log(postData);
    $.ajax({
        type: 'POST',
        async: false,
        url: "?controller=Teacher&action=addlab",
        data: postData,
        dataType: 'text',
        success: function(data){
            console.log(data);
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
    //var newNumber = $('#labNumber_' + id).val();
//    var newTitle = $('#labTitle_' + id).val();
//    var newTask = $('#labTask_' + id).val();
//    var newAccess = $('#labAccess_' + id).val();
//    var newCourse_id = $('#labCourseId_' + id).val(); 
    /* Альтернативный вариант:
    var e = document.getElementById('labCourseId_' + labId);
    var newCourse_id = e.value;*/
    
//    var postData = {labId: id, newNumber: newNumber, 
//                    newTitle: newTitle, newTask: newTask, newAccess: newAccess,
//                    newCourse_id: newCourse_id};
    
    var postData = {labId: id};
                
    $.ajax({
        type: 'POST',
        async: false,
        url: "?controller=Teacher&action=updatelab",
        data: postData,
        dataType: 'text',
        success: function(data){
            console.log(data);
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
            //window.location.reload();
            window.location.href = "http://localhost/labserviceOOP/www/"
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



function addLab() {
    $("form").on("submit", function(e){
        e.preventDefault();
        var form = $(this),
            title = $('#lab_title').val(),
            task = $('#lab_task').val(),
            course = $('#course_id').val(),
            data = new FormData(this),
            url = "?controller=Teacher&action=addlab&title=" + title + "&task=" + task + "&course=" + course;
            console.log("hello");
            console.log(title);
            console.log(url);
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            cache: false,
            async: true,
            contentType: false,
            processData: false,
            mimeType: "multipart/form-data",
            dataType : "text",
            success: function(data){
                console.log(data);
                
                window.location.reload();
            },
            error: function (xhr, thrownError, data) {
                console.log(data);
                alert(xhr.status);
                alert(thrownError);
                
                setTimeout(function(){
                    form.trigger("reset");
                }, 3000);
            }
        });
    });
};


function setGrade(id) {
    var grade = $('#execGrade_' + id).val();
    var postData = {id: id, grade:grade};
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "?controller=Teacher&action=setgrade",
        data: postData,
        dataType: 'text',
        success: function(data){
            console.log(data);
            var jsonData = JSON.parse(data);
            alert(jsonData['message']);
            console.log(jsonData['message']);
            //window.location.reload();
        },
        error: function (xhr, ajaxOptions, thrownError, data) {
            console.log(data);
            alert(xhr.status);
            alert(thrownError);
        }
    });
};
