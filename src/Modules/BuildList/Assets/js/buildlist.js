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
            ht += '<div class=" well well-sm">' ;
            ht += '  <h5><strong>Pipeline:</strong> '+data[index].item+' &nbsp;&nbsp;&nbsp;<span class="fa fa-spinner fa-spin fa-2x"></span></h5>' ;
            ht += '  <h5><strong>Pipedir:</strong> '+data[index].pipedir+'</h5>' ;
            ht += '  <h5><strong>PID:</strong> '+data[index].pid+'</h5>' ;
            ht += '  <h5><strong>Source:</strong> '+data[index].brs+'</h5>' ;
            ht += '  <h5><strong>Run ID:</strong> '+data[index].runid+'</h5>' ;
            ht += '  <h5><strong>User:</strong> '+data[index].runuser+'</h5>' ;
            ht += '</div>' ;}
            
        $('#runningBuilds').html(ht); }
}