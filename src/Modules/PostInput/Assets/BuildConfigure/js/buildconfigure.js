done = false ;
max = 0 ;
window.outUpdater = setInterval(function () { updatePage() }, 5000);

function updatePage() {
    console.log("running update page js method");
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

function setStatus() {
    item = window.pipeitem ;
    pid = window.runid ;
    url = "/index.php?control=PipeRunner&action=pipestatus&item=" + item + "&pid=" + pid + "&output-format=PIPESTATUS";
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

function changeModule(element) {
    alert("dave") ;
    alert(element) ;
    subhtml  = '<select name="step-selector" id="step-selector">';
    subhtml += '  <option value="value">A Value</option>';
    subhtml += '</select>' ;
    $("#new_step_type_selector").html(subhtml) ;
}