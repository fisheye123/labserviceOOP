/**
 * Получение данных с формы
 * 
 * @param {string} obj_form элемент html документа
 * @returns {array} массив полученных данных с элемента страницы
 */
function getData(obj_form){
    var hData = {};
    $('input, textarea, select', obj_form).each(function(){
        if( this.name && this.name != '' ){
            hData[this.name] = this.value;
            console.log('hData[' + this.name + '] = ' + hData[this.name]);
        }
    });
    return hData;
};

/**
 * Авторизация
 * 
 */
function login() {
    var postData = getData('#loginBox');
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "?controller=Auth&action=login",
        data: postData,
        dataType: 'text',
        success: function(data){
            console.log(data);
            var jsonData = JSON.parse(data);
            console.log(jsonData);
            if (jsonData['success']){
                window.location.reload();
            } else {
                alert(jsonData['message']);
            }
        },
        error: function (xhr, thrownError, data) {
            console.log(data);
            console.log(xhr.status);
            console.log(thrownError);
            alert(xhr.status);
        }
    });
}
