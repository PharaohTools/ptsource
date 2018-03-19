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
            ht = $($.parseJSON(window.delfilesht)) ;
            console.log('ajax result');
            console.log(ht);
            result = ht[0] ;
            if (result['status'] === 'SUCCESS') {
                btnclass = 'btn-success' ;
                $('#version').removeAttr('disabled');
                $('#ajaxMessages').html('<span class="btn '+btnclass+'">'+result["outmsg"]+'</span>');
                $('#updatable').html('');
            } else if (result['status'] === 'FAIL'){
                btnclass = 'btn-danger' ;
                $('#ajaxMessages').html('<span class="btn '+btnclass+'">'+result["outmsg"]+'</span>');
            } else if (result['status'] === 'FAIL'){
                btnclass = 'btn-warning' ;
                $('#ajaxMessages').html('<span class="btn '+btnclass+'">Unknown Result</span>');
            }
        },
        failure: function(data) {
            // alert('fail') ;
            $('#ajaxMessages').html('<span class="btn btn-danger">Error attempting to delete file</span>');
        }
    });

}

setDZOptions() ;
