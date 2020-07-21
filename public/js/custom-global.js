var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')

/************************************************/
/* Functions to facilitate image upload preview */
/************************************************/
function previewImageFile(ImgFileName, ImgFileNameRemoveBtn, FileInputElemName, RemoveBtnShow = true) {
    var preview = document.getElementById(ImgFileName);
    var file    = document.getElementById(FileInputElemName).files[0];
    var removeBtn = document.getElementById(ImgFileNameRemoveBtn);
    var reader  = new FileReader();

    reader.addEventListener("load", function () {
        preview.src = reader.result;
    }, false);
    if (file) {
        preview.style.display = 'block';
        if(RemoveBtnShow) {
            removeBtn.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }    
}

function removeImageFile(ImgFileName, ImgFileNameRemoveBtn, FileInputElemName) {
    var preview = document.getElementById(ImgFileName);
    var fileInput    = document.getElementById(FileInputElemName);
    var removeBtn = document.getElementById(ImgFileNameRemoveBtn);

    preview.style.display = 'none';
    removeBtn.style.display = 'none';
    fileInput.value = '';
}

function FlashMsg(msg, theme = 'success', fading = 1) {
	var msgTag = '<div class="alert alert-' + theme + '">' +
	'<button type="button" class="close" data-dismiss="alert">&times;</button>' +
	'<strong><i class="glyphicon glyphicon-ok-sign push-5-r"></</strong> ' + 
	msg + '</div>';
	$('.messages').html(msgTag);
	if(fading == 1) {
		$('div.alert').delay(500).fadeOut(400);
	}
}
