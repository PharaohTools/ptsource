Dropzone.options.manualUploadDrop = {
    init: function () {
        // Set up any event handlers
        this.on("processing", function() {
            item = $('#itemid').val() ;
            version = document.getElementById('version').value ;
            dz_url = "/index.php?control=ManualUpload&action=fileupload&item="+item+"&version="+version+"&output-format=SERVICE" ;
            this.options.url = dz_url;
        });
        this.on('complete', function () {
            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                disableVersion();
                addDeleteLink();
                window.del_dropzone = this ;
            }
        });
    }
};

function disableVersion() {
    $('#version').attr('disabled', 'disabled');
}

function addDeleteLink() {
    ht =  '<span class="fileRow">';
    ht += '<a class="btn btn-warning" onclick="deleteFile(); ' ;
    ht += 'return false;">Delete Uploaded Release</a>' ;
    ht += '</span>' ;
    $('#updatable').html(ht);
}
