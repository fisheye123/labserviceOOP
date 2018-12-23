/**
 * Добавление курса
 * 
 */
function addCourse() {
    var postData = getData('#add-course-form');
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "?controller=Admin&action=addcourse",
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
 * Изменение данных курса
 * 
 * @param {integer} id
 */
function updateCourse(id) {
    var newTitle = $('#courseTitle_' + id).val();
    var newDescription = $('#courseDescription_' + id).val();
    var newLogin = $('#courseLogin_' + id).val();
    var newPassword = $('#coursePassword_' + id).val();
    
    var postData = {id: id, newTitle: newTitle, 
                    newDescription: newDescription,
                    newLogin: newLogin, newPassword: newPassword};
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "?controller=Admin&action=updatecourse",
        data: postData,
        dataType: 'text',
        success: function(data){
            console.log(data);
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
 * Удаление курса
 * 
 * @param {integer} id
 */
function deleteCourse(id) {
    var postData = {id: id};
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "?controller=Admin&action=deletecourse",
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
 * Добавление студента
 * 
 */
function addStudent() {
    var postData = getData('#add-student-form');
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "?controller=Admin&action=addstudent",
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
 * Изменение данных студента
 * 
 * @param {integer} id
 */
function updateStudent(id) {
    var newName = $('#studentName_' + id).val();
    var newGroup = $('#studentGroup_' + id).val();
    
    var postData = {id: id, newName: newName, newGroup: newGroup};
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "?controller=Admin&action=updatestudent",
        data: postData,
        dataType: 'text',
        success: function(data){
            console.log(data);
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
 * Удаление студента
 * 
 * @param {integer} id
 */
function deleteStudent(id) {
    var postData = {id: id};
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "?controller=Admin&action=deletestudent",
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
 * Добавление преподавателя
 * 
 */
function addTeacher() {
    var postData = getData('#registerBox');
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "?controller=Admin&action=addteacher",
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
};

/**
 * Изменение данных преподавателя
 * 
 * @param {integer} id
 */
function updateTeacher(id) {    
    var newName = $('#teacherName_' + id).val();
    var newEmail = $('#teacherEmail_' + id).val();
    var newLogin = $('#teacherLogin_' + id).val();
    var newPassword = $('#teacherPassword_' + id).val();
    
    var postData = {teacherId: id, newName: newName, newEmail: newEmail, 
                    newLogin: newLogin, newPassword: newPassword};
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "?controller=Admin&action=updateteacher",
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
 * Удаление преподавателя
 * 
 * @param {integer} id
 */
function deleteTeacher(id) {
    var postData = {id: id};
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "?controller=Admin&action=deleteteacher",
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
 * Добавление лабораторной
 * 
 */
function addLab() {
    var postData = getData('#add-lab-form');
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "?controller=Admin&action=addlab",
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
        url: "?controller=Admin&action=updatelab",
        data: postData,
        dataType: 'text',
        success: function(data){
            console.log(data);
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
        url: "?controller=Admin&action=deletelab",
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