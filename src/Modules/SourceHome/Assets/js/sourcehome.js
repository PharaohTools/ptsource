function loadAllIssueCount() {
    console.log("running refresh submitter list js method");
    url = "/index.php?control=SourceHome&action=get-all-issue-counts&output-format=JSON";
    $("#total-holder").show() ;
    $.ajax({
        async: true,
        url: url,
        success: function(data) {
            $("#total-holder").html(data) ;
            $("#total-holder-parent").removeClass('loading-ajax') ;
            $("#total-holder-parent").addClass('ajax-loaded') ;
        },
        failure: function(data) {
            $("#total-holder").html("Error") ;
            $("#total-holder-parent").removeClass('loading-ajax') ;
            $("#total-holder-parent").addClass('ajax-loaded') ;
        }
    });
}

function loadSubmittedIssueCount() {
    console.log("running refresh submitter list js method");
    url = "/index.php?control=SourceHome&action=get-submitted-issue-counts&output-format=JSON";
    $("#submitted-holder").show() ;
    $.ajax({
        async: true,
        url: url,
        success: function(data) {
            $("#submitted-holder").html(data) ;
            $("#submitted-holder-parent").removeClass('loading-ajax') ;
            $("#submitted-holder-parent").addClass('ajax-loaded') ;
        },
        failure: function(data) {
            $("#submitted-holder").html("Error") ;
            $("#submitted-holder-parent").removeClass('loading-ajax') ;
            $("#submitted-holder-parent").addClass('ajax-loaded') ;
        }
    });
}

function loadWatchingIssueCount() {
    url = "/index.php?control=SourceHome&action=get-watching-issue-counts&output-format=JSON";
    $("#watching-holder").show() ;
    $.ajax({
        async: true,
        url: url,
        success: function(data) {
            $("#watching-holder").html(data) ;
            $("#watching-holder-parent").removeClass('loading-ajax') ;
            $("#watching-holder-parent").addClass('ajax-loaded') ;
        },
        failure: function(data) {
            $("#watching-holder").html("Error") ;
            $("#watching-holder-parent").removeClass('loading-ajax') ;
            $("#watching-holder-parent").addClass('ajax-loaded') ;
        }
    });
}

function loadAssignedIssueCount() {
    url = "/index.php?control=SourceHome&action=get-assigned-issue-counts&output-format=JSON";
    $("#assigned-holder").show() ;
    $.ajax({
        async: true,
        url: url,
        success: function(data) {
            $("#assigned-holder").html(data) ;
            $("#assigned-holder-parent").removeClass('loading-ajax') ;
            $("#assigned-holder-parent").addClass('ajax-loaded') ;
        },
        failure: function(data) {
            $("#assigned-holder").html("Error") ;
            $("#assigned-holder-parent").removeClass('loading-ajax') ;
            $("#assigned-holder-parent").addClass('ajax-loaded') ;
        }
    });
}

