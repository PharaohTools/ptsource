

function jsAreYouSure(message, yesfunction, inject_fields, function_after_inject) {
    inject_fields = inject_fields || false;
    function_after_inject = function_after_inject || false;
    htmlvar  = '<div id="overlay_are_you_sure"> ';
    htmlvar += '    <div class="overlay_inner"> ';
    htmlvar += '        <div id="close_button_div"> ';
    htmlvar += '            <a onclick="closeOverlay(\'are_you_sure\'); return false;"> ';
    htmlvar += '                <img src="/Assets/Modules/DataBulk/images/close-button.png" /> ';
    htmlvar += '            </a> ';
    htmlvar += '        </div> ';
    htmlvar += '        <div class="overlay_content"> ';
    htmlvar += '            <h3 class="progressTitle">'+message+'</h3> ';
    htmlvar += '            <div class="fullWidth"> ';
    htmlvar += '                <div id="inject_space">';
    if (inject_fields !== false) {
        inject_html = getInjectedFieldData(inject_fields) ;
//        console.log("inj: ", inject_html) ;
        htmlvar += inject_html ; }
    htmlvar += '                </div>';
    htmlvar += '            </div> ';
    htmlvar += '            <div class="fullWidth"> ';
    htmlvar += '                <button id="are_you_sure_yes" class="btn btn-success hvr-float-shadow">Yes</button> ';
    htmlvar += '                <button id="are_you_sure_no" onclick="closeOverlay(\'are_you_sure\') ;" class="btn btn-warning hvr-float-shadow">No</button> ';
    htmlvar += '            </div> ';
    htmlvar += '            <div class="fullWidth"> ';
    htmlvar += '                <div id="overlay_data"></div>';
    htmlvar += '            </div> ';
    htmlvar += '        </div> ';
    htmlvar += '    </div> ';
    htmlvar += '</div> ';

//    console.log("appending: ", htmlvar);

    $('body').append(htmlvar) ;

    if (function_after_inject !== false) {
        if (typeof function_after_inject === "function") {
            function_after_inject() ;
        }
        window[function_after_inject]();
    }

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

function getInjectedFieldData(ifstring) {
//    ifstype = (typeOf ifstring) ;
    console.log("ifs type", ifstring) ;
    if (typeof ifstring === "function") {
        ifsval = ifstring() ;
        console.log("ifs val", ifsval) ;
        return ifsval ;
    }
    return $('#'+ifstring).html();

}


function closeOverlay(type) {
    $('#overlay_'+type).remove() ;
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
