Dropzone.options.manualUploadDrop = {
    init: function () {
        // Set up any event handlers
        this.on("processing", function() {
            item = $('#itemid').val() ;
            version = document.getElementById('version').value ;
            dz_url = "/index.php?control=ManualUpload&action=fileupload&item="+item+"&version="+version+"&output-format=SERVICE" ;
            console.log('dz');
            console.log(dz_url);
            this.options.url = dz_url;
        });
        this.on('complete', function () {
            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                // reloadFiles();̣
                disableVersion();
                addDeleteLink();
                window.del_dropzone = this ;
            }
        });
    }
};

function setDZOptions(that) {
    // console.log('that') ;
    // console.log(that) ;
    // console.log('Change Dropzone') ;
    // console.log(dz_url) ;
    // mud = $('#manualUploadDrop') ;
    // mud.hide() ;
    // Dropzone.options.manualUploadDrop = {
    //     url: dz_url,
    //     init: function () {
    //
    //         this.on("processing", function() {
    //             this.options.url = dz_url;
    //             item = $('#itemid').val() ;
    //             version = $('#version').val() ;
    //             dz_url = "/index.php?control=ManualUpload&action=fileupload&item="+item+"&version="+version+"&output-format=SERVICE" ;
    //         });
    //         this.on('complete', function () {
    //             if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
    //                 disableVersion();
    //                 addDeleteLink();
    //                 window.del_dropzone = this ;
    //             }
    //         });
    //     }
    // };
    // mud.show() ;
}

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
