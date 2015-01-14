done = false ;
max = 0 ;
while (done == false && max < 30) {
    window.setTimeout(updatePage, 3000) //wait 3 seconds before continuing
    max = max + 1 ; }

// updatePage() ;

function updatePage() {
    console.log("running update page js method");
    item = $("#item").val();
    url = "/index.php?control=PipeRunner&action=service&item=" + item ;
    $.ajax({
        url: url,
        success: function(data) {
            $('#updatable').html(data); },
        complete: function() {
            // Schedule the next request when the current one's complete
            setStatus();
            console.log(window.reqStatus);
            if (window.reqStatus == "OK") {
                doCompletion();
            } else {
                setTimeout(updatePage, 3000); } }
    });
}

function setStatus() {
    item = $("#item").val();
    pid = $("#pid").val();
    url = "/index.php?control=PipeRunner&action=pipestatus&item=" + item + "&pid=" + pid ;
    console.log(url);
    $.ajax({
        url: url,
        success: function(data) {
            console.log(data);
            window.reqStatus = data }
    });
}

function doCompletion() {
    saveRun();
    removeWaitImage();
    changeSubButton();
}

function removeWaitImage() {
    $("#loading-holder").hide() ;
}

function changeSubButton() {
    subhtml  = '<div class="col-sm-offset-2 col-sm-8">';
    subhtml += '  <div class="text-center">';
    subhtml += '    <button type="submit" class="btn btn-primary" id="close-complete">Close Execution Screen</button>';
    subhtml += '  </div>';
    subhtml += '</div>' ;
    $("#submit-holder").html(subhtml) ;
}

function saveRun() {
    item = $("#item").val();
    pid = $("#pid").val();
    url = "/index.php?control=PipeRunner&action=saverun&item=" + item + "&pid=" + pid ;
    console.log(url);
    $.ajax({
        url: url,
        success: function(data) {
            console.log(data);
            window.reqStatus = data }
    });

}