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

function getFileParam() { 			
    try { 				
        var file = document.getElementById('file').files[0]; 				

        if (file) { 					
            var fileSize = 0; 					

            if (file.size > 1024 * 1024) {
                fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
            }else {
                fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
            }

            document.getElementById('file-name1').innerHTML = 'Имя: ' + file.name;
            document.getElementById('file-size1').innerHTML = 'Размер: ' + fileSize;

            if (/\.(jpe?g|bmp|gif|png)$/i.test(file.name)) {		
                var elPreview = document.getElementById('preview1');
                elPreview.innerHTML = '';
                var newImg = document.createElement('img');
                newImg.className = "preview-img";

                if (typeof file.getAsDataURL=='function') {
                    if (file.getAsDataURL().substr(0,11)=='data:image/') {
                        newImg.onload=function() {
                            document.getElementById('file-name1').innerHTML+=' ('+newImg.naturalWidth+'x'+newImg.naturalHeight+' px)';
                        }
                        newImg.setAttribute('src',file.getAsDataURL());
                        elPreview.appendChild(newImg);								
                    }
                }else {
                    var reader = new FileReader();
                    reader.onloadend = function(evt) {
                        if (evt.target.readyState == FileReader.DONE) {
                            newImg.onload=function() {
                                document.getElementById('file-name1').innerHTML+=' ('+newImg.naturalWidth+'x'+newImg.naturalHeight+' px)';
                            }

                            newImg.setAttribute('src', evt.target.result);
                            elPreview.appendChild(newImg);
                    }
                    };

                    var blob;		
                    if (file.slice) {
                        blob = file.slice(0, file.size);
                    }else if (file.webkitSlice) {
                            blob = file.webkitSlice(0, file.size);
                        }else if (file.mozSlice) {
                            blob = file.mozSlice(0, file.size);
                        }
                    reader.readAsDataURL(blob);
                }
            }
        }
    }catch(e) {
        var file = document.getElementById('file').value;
        file = file.replace(/\\/g, "/").split('/').pop();
        document.getElementById('file-name1').innerHTML = 'Имя: ' + file;
    }
}