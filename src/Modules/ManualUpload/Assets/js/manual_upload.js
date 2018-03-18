
function deleteFile() {
    item = $('#itemid').val() ;
    version = $('#version').val() ;
    url = "/index.php?control=ManualUpload&action=filedelete&item="+item+"&version="+version+"&output-format=SERVICE";
    dlh = $("#manual-upload-loading-holder") ;
    dlh.show() ;
    $.ajax({
        url: url,
        async: false,
        success: function(data) {
            window.delfilesht = data ;
            // alert('success') ;
            window.del_dropzone.removeAllFiles() ;

            $('#version').attr('enabled', 'enabled');
        },
        failure: function(data) {
            // alert('fail') ;
        }
    });
    ht = $($.parseJSON(window.delfilesht)) ;
    console.log(ht[0]["outmsg"]);
    $('#ajaxMessages').html('<p>'+ht[0]["outmsg"]+'</p>');

    dlh.hide() ;
    ht = '' ;
    $('#updatable').html(ht);
}
