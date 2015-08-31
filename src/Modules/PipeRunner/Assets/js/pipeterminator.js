done = false ;
max = 0 ;
window.updateRunning = false ;
window.outUpdater = setInterval(function () {
    if (window.updateRunning==false) {
        console.log("calling update page js method, updateRunning variable is set to false");
        updatePage() ; }
    else {
        console.log("not calling update page js method, updateRunning variable is set to true"); }
}, 4000);

function updatePage() {
    console.log("running update page js method");
    window.updateRunning = true ;
    console.log("setting update running to true");
    item = window.pipeitem ;
    url = "/index.php?control=PipeRunner&action=termservice&item=" + item + "&run-id=" + runid + "&output-format=SERVICE";
    $.ajax({
        url: url,
        success: function(data) {
            $('#updatable').html(data);
            window.updateRunning = false ; },
        complete: function() {
            // Schedule the next request when the current one's complete
            setStatus();
            console.log("Req Status: " + window.reqStatus);
            if (window.reqStatus == "OK") {
                doCompletion(); }
            window.updateRunning = false ; }
    });
}

function setStatus() {
    item = window.pipeitem ;
    runid = window.runid ;
    url = "/index.php?control=PipeRunner&action=termstatus&item=" + item + "&run-id=" + runid + "&output-format=TERMSTATUS";
    console.log(url);
    $.ajax({
        url: url,
        success: function(data) {
            window.reqStatus = data ;
            console.log("pipestat: " + data) ;
        }
    });
}

function doCompletion() {
    removeWaitImage();
    changeSubButton();
    clearInterval(window.outUpdater);
}

function removeWaitImage() {
    $("#loading-holder").hide() ;
}

function changeSubButton() {
    subhtml  = '<div class="col-sm-offset-2 col-sm-8">';
    subhtml += '  <div class="text-center">';
    subhtml += '    <button type="submit" class="btn btn-primary" id="close-complete">Close Termination Screen</button>';
    subhtml += '  </div>';
    subhtml += '</div>' ;
    $("#submit-holder").html(subhtml) ;
}