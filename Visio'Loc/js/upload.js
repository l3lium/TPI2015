/*
 ======Upload.js======
 Auteur: 	Oliveira Stéphane
 Classe: 	I.IN-P4B
 Date:		05/05/2015
 Version:	0.1
 Description:    Script permettant d'upload la video et l'affiche du film
 */

$(document).ready(function() {
    var inputImg = $("input[name='poster'][type='file']");

    inputImg.change(function() {
        $("#uploadPoster").attr("class", "form-group").click(function() {
            $("#progressPoster").attr("class", "progress");
        });
    });

    var options = {
        target: '#output', // target element(s) to be updated with server response 
        beforeSubmit: beforeSubmit, // pre-submit callback 
        success: afterSuccess, // post-submit callback 
        uploadProgress: OnProgress, //upload progress callback 
        resetForm: true        // reset the form after successful submit 
    };


});

function OnProgress(event, position, total, percentComplete)
{
    //Progress bar
    $('#progressbox').show();
    $('#progressbar').width(percentComplete + '%') //update progressbar percent complete
    $('#statustxt').html(percentComplete + '%'); //update status text
    if (percentComplete > 50)
    {
        $('#statustxt').css('color', '#000'); //change status text to white after 50%
    }
}
/*
 $(document).ready(function() {
 console.log("ready!");
 //var inputPoster = $("input[type='file'][name='poster']");
 //var inputVideo = $("input[type='file'][name='video']");
 var videoUpload = $("#upload-group-video");
 
 console.debug(videoUpload.children("#input-video"));
 $(videoUpload).children("#input-video").change(function() {
 console.debug("souso");
 });
 
 $(videoUpload).change(function() {
 var self = this;
 //this.disabled = true;
 $("#uploadVideo").attr("class", "show");
 $(this).children("#uploadVideo").attr("class", "show");
 
 $("#uploadVideo button").click(function() {
 console.debug("dadada");
 $(self).children("#progressVideo").attr("class", "show");
 });
 });
 $('form').on('submit', uploadFiles);
 
 // Catch the form submit and upload the files
 
 });
 
 function uploadFiles(event)
 {
 event.stopPropagation(); // Stop stuff happening
 event.preventDefault(); // Totally stop stuff happening
 
 // START A LOADING SPINNER HERE
 
 // Create a formdata object and add the files
 var data = new FormData();
 $.each(files, function(key, value)
 {
 data.append(key, value);
 });
 
 $.ajax({
 url: 'submit.php?files',
 type: 'POST',
 data: data,
 cache: false,
 dataType: 'json',
 processData: false, // Don't process the files
 contentType: false, // Set content type to false as jQuery will tell the server its a query string request
 success: function(data, textStatus, jqXHR)
 {
 if (typeof data.error === 'undefined')
 {
 // Success so call function to process the form
 submitForm(event, data);
 }
 else
 {
 // Handle errors here
 console.log('ERRORS: ' + data.error);
 }
 },
 error: function(jqXHR, textStatus, errorThrown)
 {
 // Handle errors here
 console.log('ERRORS: ' + textStatus);
 // STOP LOADING SPINNER
 }
 });
 }
 */