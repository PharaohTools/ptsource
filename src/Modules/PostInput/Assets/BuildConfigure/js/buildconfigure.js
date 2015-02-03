done = false ;
max = 0 ;

function updatePage() {
    item = window.pipeitem ;
    url = "/index.php?control=PipeRunner&action=service&item=" + item + "&output-format=SERVICE";
    $.ajax({
        url: url,
        success: function(data) {
            $('#updatable').html(data); },
        complete: function() {
            // Schedule the next request when the current one's complete
            setStatus();
            console.log("Req Status: " + window.reqStatus);
            if (window.reqStatus == "OK") {
                doCompletion(); } }
    });
}

function doCompletion() {
    removeWaitImage();
    changeSubButton();
}

function removeWaitImage() {
    $("#loading-holder").hide() ;
}

function changeModule(element) {
    module = $("#new_module_selector").find(":selected").text() ;
    alert(module) ;
    selectoptions = window.steps[module] ;
    console.log(selectoptions) ;
}