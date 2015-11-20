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
    url = "/index.php?control=PipeRunner&action=findrunning&output-format=JSON";
    $.ajax({
        url: url,
        success: function(data) {
            setRunningBuildList(data) ;
            window.updateRunning = false ; } ,
        complete: function(data) {
            window.updateRunning = false ; }
    });
}

var row;
function setRunningBuildList(data) {
    data = JSON.parse(data);
    console.log(data);
    if (data.length == 0) {
        $('.runningBuildRow' +" > td ").animate({ opacity: 100 });
        $('.runningBuildRow' +" > th ").animate({ opacity: 100 });
        $('.buildRow').removeClass("runningBuildRow");
        ht = "<p>No builds currently being executed...</p>" ;
        $('#runningBuilds').html(ht); }
    else {
        ht = "" ;
        for (index = 0; index < data.length; index++) {
            $('#blRow_'+data[index].item).addClass("runningBuildRow");
            //$('#blRow_'+data[index].item +" > td ").css('display',"none");
            $('.runningBuildRow' +" > td ").animate({ opacity: 0 });
            $('.runningBuildRow' +" > th ").animate({ opacity: 0 });
            //row = $('#blRow_'+data[index].item +" > td ").html();
            //$('#blRow_'+data[index].item +" > td ").html(' ');
            ht += '<div class=" well well-sm">' ;
            ht += '  <img src="Assets/startbootstrap-sb-admin-2-1.0.5/dist/image/rt.GIF" style="width:150px;">' ;
            ht += '  <h5><strong>Pipeline:</strong> '+data[index].item+'</h5>' ;
            ht += '  <h5><a href="index.php?control=PipeRunner&action=show&item='+data[index].item+'&run-id='+data[index].runid+'">' ;
            ht += '  <strong>Build start at:</strong> '+data[index].starttime+'</a></h5>' ;
            ht += '  <h5><strong>Pipedir:</strong> '+data[index].pipedir+'</h5>' ;
            ht += '  <h5><strong>PID:</strong> '+data[index].pid+'</h5>' ;
            ht += '  <h5><strong>Source:</strong> '+data[index].brs+'</h5>' ;
            ht += '  <h5><a href="index.php?control=PipeRunner&action=show&item='+data[index].item+'&run-id='+data[index].runid+'"> ' ;
            ht += '  <strong>Run ID:</strong> '+data[index].runid+'</a></h5>' ;
            ht += '  <h5><strong>User:</strong> '+data[index].runuser+'</h5>' ;
            ht += '</div>' ;}
            
        $('#runningBuilds').html(ht); }
}