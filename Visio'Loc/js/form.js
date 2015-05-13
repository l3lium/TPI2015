/*
 ======Upload.js======
 Auteur: 	Oliveira Stéphane
 Classe: 	I.IN-P4B
 Date:		05/05/2015
 Version:	0.1
 Description:    Script permettant d'upload la video et l'affiche du film
 */

/** Date.toInputDate
 * Retourne la date pour input type date
 * @returns {String} la date au format YYYY-MM-DD
 */
Date.prototype.toInputDate = function () {
    var yyyy = this.getFullYear().toString();
    var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based
    var dd = this.getDate().toString();
    return yyyy + "-" + (mm[1] ? mm : "0" + mm[0]) + "-" + (dd[1] ? dd : "0" + dd[0]); // padding
};


$(document).ready(function () {
    var posterInput = $("#input-poster");
    var videoInput = $("#input-video");
    var subInput = $("#input-sub");

    //Upload de l'affiche
    posterInput.change(function () {
        //Affichage du bouton upload poster
        $("#upload-poster").attr("class", "form-group");

        //Ajout de l'evenement du bouton upload poster
        $("#upload-poster button").click(function () {

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

    //Upload de vidéo
    videoInput.change(function () {
        var input = $(this);
        //Affichage du bouton upload poster
        $("#upload-video").attr("class", "form-group");

        //Ajout de l'evenement du bouton upload poster
        $("#upload-video button").click(function () {

            var progressBar = $("#progress-bar-video");
            var url = $(this).attr('data-url-upload');
            console.debug(videoInput.attr("name"), videoInput[0].files[0]);
            var formData = new FormData();
            //Ajout du fichier
            formData.append(videoInput.attr("name"), videoInput[0].files[0]);

            //Upload de la video
            uploadFile(url, formData, progressBar);
            videoInput.attr("disabled", "true");
            $(this).hide();
        });
    });
    
    //Upload de sous-titres
    subInput.change(function () {
        //Affichage du bouton upload poster
        $("#upload-sub").attr("class", "form-group");

        //Ajout de l'evenement du bouton upload poster
        $("#upload-sub button").click(function () {

            var progressBar = $("#progress-bar-sub");
            var url = $(this).attr('data-url-upload');

            var formData = new FormData();
            //Ajout du fichier
            formData.append(subInput.attr("name"), subInput[0].files[0]);

            //Upload du sous-titre
            uploadFile(url, formData, progressBar);
            subInput.attr("disabled", "true");
            $(this).hide();
        });
    });

    //Fenetre modal suppression de film
    $(".btn-delete-movie").click(function () {
        row = $(this).parents().eq(1);//Recupere le parent du parent (grand-parent)
        id = row.children(".cell-id").html();
        title = row.children(".cell-title").html();

        //Affichage message
        $("#modal-delete-movie #modal-msg").html("Êtes vous sur de vouloir supprimer le film suivant : " + title);
        //Ajout input id
        $("input[name='id']").val(id);

        //Affichage modal
        $("#modal-delete-movie").modal("show");
    });
    
    //Fenetre modal suppression de sous-titre
    $(".btn-delete-sub").click(function () {
        row = $(this).parents().eq(1);//Recupere le parent du parent (grand-parent)
        idMovie = row.children(".cell-id-movie").html();
        idLang = row.children(".cell-id-lang").html();
        lang = row.children(".cell-lang").html();
        
        //Affichage message
        $("#modal-delete-sub #modal-msg").html("Êtes vous sur de vouloir supprimer le sous-titre "+lang);
        //Ajout input id
        $("input[name='idMovie']").val(idMovie);
        $("input[name='idLang']").val(idLang);

        //Affichage modal
        $("#modal-delete-sub").modal("show");
    });
    
    
    //Aide à la saisie
    $("#input-help").click(function () {
        console.debug(getMovieOMDB($("input[name='title']").val()));
    });

});

/** getMovieOMDB
 * Récupére les informations d'un film via omdbapi
 * @param {string} title
 * @returns {json} movie
 */
function getMovieOMDB(title) {
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: 'http://www.omdbapi.com/?t=' + title,
        statusCode: {
            403: function () {
                console.debug('HTTP 403 Forbidden!')
            }
        },
        success: function (a) {
            setInputHelp(a);
        }
    });
}

/** setInputHelp
 * Met à jour les champs du formuaire
 * @param {json} movie
 * @returns 
 */
function setInputHelp(movie) {
    console.debug(movie);
    if (!movie.Error) {
        $("input[name='title']").val(movie.Title);
        var date = new Date(movie.Released);
        $("input[name='date']").val(date.toInputDate());
        $("textarea[name='synopsis']").val(movie.Plot);
        $("#input-help-msg").html("");
    } else {
        $("#input-help-msg").html("Aucun film trouvé");
    }
}

/** uploadFile
 * Upload un fichier sur le serveur
 * @param {string} url l'addresse du script de traitement de fichier
 * @param {FormData} formData les paramètres du formulaire (fichiers)
 * @param {Jquery DOM} progressBar la barre de progression à mettre à jour 
 */
function uploadFile(url, formData, progressBar) {
    var result;
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false, // Don't process the files
        contentType: false,
        cache: false,
        success: function (msg) {
            console.debug(msg);

            progressBar.parents().eq(1).after(msg);
        },
        xhr: function () {
            // get the native XmlHttpRequest object
            var xhr = $.ajaxSettings.xhr();
            // set the onprogress event handler
            xhr.upload.onprogress = function (evt) {
                progressBar.parent().attr("class", "progress");
                var percent = Math.floor(evt.loaded / evt.total * 100);
                progressBar.width(percent + "%").attr("aria-valuenow", percent).html(percent + "%");
            };
            // set the onload event handler
            xhr.upload.onload = function () {
                console.log('DONE!');
                progressBar.parent().attr("class", "progress");
            };
            // return the customized object
            return xhr;
        }

    });
}