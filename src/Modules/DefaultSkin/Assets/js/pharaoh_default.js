

function jsAreYouSure(message, yesfunction) {
    html  = '<div id="overlay_are_you_sure"> ';
    html += '    <div class="overlay_inner"> ';
    html += '        <div id="close_button_div"> ';
    html += '            <a onclick="closeOverlay(\'are_you_sure\'); return false;"> ';
    html += '                <img src="/Assets/Modules/IssueBulk/images/close-button.png" /> ';
    html += '            </a> ';
    html += '        </div> ';
    html += '        <div class="overlay_content"> ';
    html += '            <h3 class="progressTitle">'+message+'</h3> ';
    html += '            <div class="fullWidth"> ';
    html += '                <button id="are_you_sure_yes" class="btn btn-success hvr-float-shadow">Yes</button> ';
    html += '                <button id="are_you_sure_no" onclick="closeOverlay(\'are_you_sure\') ;" class="btn btn-warning hvr-float-shadow">No</button> ';
    html += '            </div> ';
    html += '            <div class="fullWidth"> ';
    html += '                <div id="overlay_data"></div>';
    html += '            </div> ';
    html += '        </div> ';
    html += '    </div> ';
    html += '</div> ';

    $('body').append(html) ;

    $('#are_you_sure_yes').off("click").click(function() {
        console.log("before yes function: " + yesfunction);
        res = window[yesfunction]() ;
        if (res == true) {
            console.log("after yes success, close overlay now");
            closeOverlay('are_you_sure') ; }
        else {
            console.log("after but not true, dont close overlay now");
//            closeOverlay('are_you_sure') ;
        }
    });
//    $('#are_you_sure_no').off("click").click();
    $('#overlay_are_you_sure').css('display', 'block') ;

}


function closeOverlay(type) {
    $('#overlay_'+type).css('display', 'none') ;
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
