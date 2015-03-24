done = false ;
max = 0 ;
window.outUpdater = setInterval(function () { updatePage() }, 4000);

function updatePage() {
    console.log("running update page js method");
    item = window.pipeitem ;
    url = "/index.php?control=PipeRunner&action=findrunning&output-format=JSON";
    $.ajax({
        url: url,
        success: function(data) { setRunningBuildList(data) ; }
    });
}

function setRunningBuildList(data) {
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
            ht += "  <p><strong>Pipeline:</strong> "+data[index].item+"</p>" ;
            ht += "  <p><strong>Pipedir:</strong> "+data[index].pipedir+"</p>" ;
            ht += "  <p><strong>PID:</strong> "+data[index].pid+"</p>" ;
            ht += "  <p><strong>Source:</strong> "+data[index].brs+"</p>" ;
            ht += "  <p><strong>Run ID:</strong> "+data[index].runid+"</p>" ;
            ht += "  <p><strong>User:</strong> "+data[index].runuser+"</p>" ;
            ht += "</div>" ; }
        $('#runningBuilds').html(ht); }
}