
var MediaList = [];
var GalleryArea = ".gallery";
var CurrentMediaEditor = {};
var CurrentMediaIndexEditor = 0;

$(document).ready(function(e){
    //CLIC UPLOAD IMAGE
    $(document).on('click', '.btn-add a', function(e){
        e.preventDefault();
        e.stopPropagation();
        initFileUpload();
    });

    //CLIC MODAL BTN EDIT
    $(document).on('click', '#modal-btn-edit', function(e){
        e.preventDefault();
        e.stopPropagation();
        updateMedia();
    });

    //CLIC MODAL BTN DELETE
    $(document).on('click', '#modal-btn-delete', function(e){
        deleteMedia();
    });

    //CLIC SET BY DEFAULT
    $(document).on('click', '.set-as-default a', function(e){
        e.preventDefault();
        e.stopPropagation();
        setImageByDefault(this);
    });

    //CLIC PICTURE
    $(document).on('click','.gallery .picture', function(e){
        if(!$(e.target).is('a')){
            openPicEditor(this);
        }
    });

});

/** INIT MEDIA LIST **/
function init_medias_list(medias){
    MediaList = medias;
}

/** INIT FILE UPLOAD **/
function initFileUpload(){
    var progress_bar = $('#progress_bar');
    var input_file = $('#fileupload');
    input_file.trigger('click');
    var filename = [];

    input_file.fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: BaseUrl+'/medias/upload',
        beforeSend: function(xhr, settings) {
            progress_bar.slideDown();
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
           /* progress_bar.text(progress+'%');*/
            progress_bar.css('width',progress + '%');
        },
        done: function(e, data,result) {
            progress_bar.slideUp();
            console.log('data :');
            console.log(data);
            var res = "";
            try {
                res = jQuery.parseJSON(data.result);
                if(res.success.success){
                    Materialize.toast('Image chargée avec succès !', 3000, 'cyan2');
                    addImageToGallery(res.success.media);
                }else{
                    Materialize.toast(res.success.msg, 3000, 'pink2');
                }
            }
            catch(e) {
                Materialize.toast("Erreur lors du chargement de l'image. Veuillez réessayer.", 3000, 'pink2');
            }
        }
    });
}

/** ADD IMAGE TO GALLERY **/
function addImageToGallery(image){
    MediaList.push(image);
    //On enlève la balise h5 "Aucune image" si nécessaire
    $('.no-image').remove();
    var image_html = getHtmlImage(image);
    $(GalleryArea).append(image_html);
}

/** GET HTML IMAGE **/
function getHtmlImage(image){
    var image_url = BaseUrl+image.url;
    var html = '<div class="picture shadow-hover">'+
                    '<img src="'+image_url+'" data-id="'+image.id+'" alt="'+image.name+'" title="'+image.name+'">'+
                    '<div class="set-as-default">'+
                        '<a href="#">mettre par défaut</a>'+
                    '</div>'+
                '</div>';
    return html;
}


/** SET IMAGE DEFAULT **/
function setImageByDefault(elem){
    var img =  $(elem).closest('.picture').find('img');
    var data_id = img.attr('data-id');
    var src = img.attr('src');
    console.log('data-id : '+data_id);

    $.ajax({
        url: BaseUrl + '/parametres/edit',
        method: "PUT",
        data: {
            ref_id : data_id,
            param_name : "profil_picture"
        },
        dataType: "json",
        success: function (json, statut) {
            if(json.success){
                Materialize.toast('Image mise par défaut !', 3000, 'cyan2');
                $('.profil_pic').attr('src', src);
            }else{
                Materialize.toast('Erreur de mise à jour du paramètre.', 3000, 'pink2');
            }
        }
    });
}

/** PIC EDITOR ***/
function openPicEditor(elem){
    var data_id = $(elem).find('img').attr('data-id');
    var media = findMediaById(data_id);
    var title = media.name;
    var description = media.description;
    var src = media.url;

    //Set infos
    $('#input-title').val(title);
    $('#textarea-description').val(description);
    $('#modal-pic-editor .picture img').attr('src', BaseUrl+src);

    //Ouverture de la modal
    $('body').addClass('popup-open');
    $('#modal-pic-editor').modal('open');
}


/** FIND MEDIA OBJECT **/
function findMediaById(id){
   /* var result = $.grep(MediaList, function(e){ return e.id == id; });*/
    var indexes = $.map(MediaList, function(obj, index) {
        if(obj.id == id) {
            return index;
        }
    });

    if(indexes.length > 0){
        //On met l'index et l'object media dans des variables globales pour ne pas avoir à les rechercher
        CurrentMediaIndexEditor = indexes[0];
        CurrentMediaEditor = MediaList[CurrentMediaIndexEditor];
        return CurrentMediaEditor;
    }else{
        Materialize.toast('Une erreur s\'est produite. Veuillez recharger la page.', 3000, 'pink2');
    }
}

/** UPDATE MEDIA **/
function updateMedia(){
    var title = $('#input-title').val();
    var description = $('#textarea-description').val();
    var media_id = CurrentMediaEditor.id;
    $('#modal-pic-editor').modal('close');
    $.ajax({
        url: BaseUrl + '/medias/edit/'+media_id,
        method: "PUT",
        data: {
            name : title,
            description : description
        },
        dataType: "json",
        success: function (json, statut) {
            if(json.success){
                Materialize.toast('Informations de l\'image enregistrés !', 3000, 'cyan2');
                CurrentMediaEditor.name = title;
                CurrentMediaEditor.description = description;
                //On met à jour la liste des médias côté JS
                MediaList[CurrentMediaIndexEditor] = CurrentMediaEditor;
                var img_element = $('img[data-id="'+CurrentMediaEditor.id+'"]');
                //On met à jour le Alt et Title de l'image
                img_element.attr('alt', title);
                img_element.attr('title',title);
            }else{
                Materialize.toast(json.msg, 3000, 'pink2');
            }
        }
    });
}

function deleteMedia(){
    var media_id = CurrentMediaEditor.id;
    $('#modal-pic-editor').modal('close');
    var profil_pic_src = $('.profil_pic').attr('src');
    var current_img_src = $('img[data-id="'+media_id+'"]').attr('src');
    if(current_img_src != profil_pic_src){
        $.ajax({
            url: BaseUrl + '/medias/delete/'+media_id,
            method: "DELETE",
            dataType: "json",
            success: function (json, statut) {
                if(json.success){
                    //On supprime l'image de l'écran
                    $('img[data-id="'+media_id+'"]').closest('.picture').remove();
                    //On supprime l'objet media côté JS
                    MediaList.splice(CurrentMediaIndexEditor, 1);
                    Materialize.toast('Image correctement supprimée !', 3000, 'cyan2');
                    //Si il n'y a plus d'images
                    if(MediaList.length == 0){
                       $('.gallery').append("<h5 class='no-image'>Aucune image</h5>");
                    }
                }else{
                    Materialize.toast(json.msg, 3000, 'pink2');
                }
            }
        });
    }else{
        Materialize.toast("Veuillez sélectionner une autre image par défaut avant de supprimer celle-ci.", 3000, 'pink2');
    }
}



