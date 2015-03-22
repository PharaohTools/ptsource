done = false ;
max = 0 ;
window.outUpdater = setInterval(function () { updatePage() }, 10000);

function updatePage() {
    console.log("running update page js method");
    item = window.pipeitem ;
    url = "/index.php?control=PipeRunner&action=findrunning&output-format=JSON";
    $.ajax({
        url: url,
        success: function(data) {
            setBuildList(data) ;
        }
//,
//        complete: function() {
//            // Schedule the next request when the current one's complete
//            setStatus();
//            console.log("Req Status: " + window.reqStatus);
//            if (window.reqStatus == "OK") {
//                doCompletion(); } }
    });
}

function setBuildList(data) {
    data = JSON.parse(data);
    console.log(data);
    if (data.length == 0) {
        $('.buildRow').removeClass("runningBuildRow");
        ht = "<p>No builds currently being executed...</p>" ;
        $('#runningBuilds').html(ht); }
    else {
        ht = "" ;
        for (index = 0; index < data.length; index++) {
            $('#blRow_'+data[index].item).addClass("runningBuildRow");
            ht += '<div class="runningBuild">' ;
            ht += "  <p>Pipeline "+data[index].item+"</p>" ;
            ht += "  <p>Pipedir "+data[index].pipedir+"</p>" ;
            ht += "  <p>PID "+data[index].pid+"</p>" ;
            ht += "  <p>Source "+data[index].brs+"</p>" ;
            ht += "  <p>Run ID "+data[index].runid+"</p>" ;
            ht += "  <p>User "+data[index].runuser+"</p>" ;
            ht += "</div>" ; }
        $('#runningBuilds').html(ht); }
}