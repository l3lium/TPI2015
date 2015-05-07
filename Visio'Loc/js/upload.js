/*
 ======Upload.js======
 Auteur: 	Oliveira Stéphane
 Classe: 	I.IN-P4B
 Date:		05/05/2015
 Version:	0.1
 Description:    Script permettant d'upload la video et l'affiche du film
 */
$(document).ready(function() {
    var posterInput = $("#input-poster");
    var videoInput = $("#input-video");
    
    posterInput.change(function() {
        //Affichage du bouton upload poster
        $("#upload-poster").attr("class", "form-group");

        //Ajout de l'evenement du bouton upload poster
        $("#upload-poster button").click(function() {
            
            var progressBar = $("#progress-bar-poster");
            var url = $(this).attr('data-url-upload');
            var formData = new FormData();
            //Ajout du fichier
            formData.append(posterInput.attr("name"), posterInput[0].files[0]);

            //Upload du poster
            uploadFile(url, formData, progressBar);
            posterInput.attr("disabled", "true");
            $(this).hide();
        });
    });
    
    videoInput.change(function() {
        var input = $(this);
        //Affichage du bouton upload poster
        $("#upload-video").attr("class", "form-group");

        //Ajout de l'evenement du bouton upload poster
        $("#upload-video button").click(function() {
            
            var progressBar = $("#progress-bar-video");
            var url = $(this).attr('data-url-upload');
            var formData = new FormData();
            //Ajout du fichier
            formData.append(videoInput.attr("name"), videoInput[0].files[0]);

            //Upload du poster
            uploadFile(url, formData, progressBar);
            videoInput.attr("disabled", "true");
            $(this).hide();
        });
    });
    
    $(".btn-delete-movie").click(function(){
        $id = $(this).parent().parent().children(".cell-id").html();
        $("#delete-modal").modal("show");
    });

});


function uploadFile(url, formData, progressBar) {
    var result;
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false, // Don't process the files
        contentType: false,
        success: function(msg) {
            console.debug(msg);
            
            progressBar.parent().parent().after(msg);
        },
        xhr: function() {
            // get the native XmlHttpRequest object
            var xhr = $.ajaxSettings.xhr();
            // set the onprogress event handler
            xhr.upload.onprogress = function(evt) {
                progressBar.parent().attr("class", "progress");
                var percent = Math.floor(evt.loaded / evt.total * 100);
                progressBar.width(percent + "%").attr("aria-valuenow", percent).html(percent + "%");
            };
            // set the onload event handler
            xhr.upload.onload = function() {
                console.log('DONE!');
                progressBar.parent().attr("class", "progress");
            };
            // return the customized object
            return xhr;
        }

    });
    return result;
}