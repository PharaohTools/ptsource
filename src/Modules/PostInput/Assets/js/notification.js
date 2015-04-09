done = false ;
max = 0 ;
window.outUpdater = setInterval(function () { updatePage(); }, 4000);

function updatePage() {
    console.log("running update page js method");
    item = window.pipeitem ;
    url = "/index.php?control=PipeRunner&action=findrunning&output-format=JSON";
    $.ajax({
        url: url,
        success: function(data) { setRunningBuildList(data) ; }
    });
}

var row;
function setRunningBuildList(data) {
    data = JSON.parse(data);
    console.log(data);
    ht = "";  
    if (data.length == 0) {
    	ht += '<li><a class="text-center" href="#"><div>' ;
        ht += "<span>No builds currently being executed...</span>" ;
        ht += '</div ></a></li>' ;
    } else {
        ht = "" ;
        for (index = 0; index < data.length; index++) {
        	ht += '<li><a class="text-center" href="#"><div>' ;
            ht += '<img src="Assets/startbootstrap-sb-admin-2-1.0.5/dist/image/rt.GIF" style="width:150px;"></br>' ;
            ht += '  <span><strong>Pipeline:</strong> '+data[index].item+'</span>' ;
            ht += '  <span><strong>Build start at:</strong> '+data[index].starttime+'</span></br>' ;
            ht += '  <span><strong>Pipedir:</strong> '+data[index].pipedir+'</span>' ;
            ht += '  <span><strong>PID:</strong> '+data[index].pid+'</span></br>' ;
            ht += '  <span><strong>Source:</strong> '+data[index].brs+'</span>' ;
            ht += '  <span><strong>Run ID:</strong> '+data[index].runid+'</span></br>' ;
            ht += '  <span><strong>User:</strong> '+data[index].runuser+'</span>' ;
            ht += '	 <li class="divider"></li>';
            ht += '</div ></a></li>' ;}
       }
       $('#runningBuildsnotif').html(ht); 
}