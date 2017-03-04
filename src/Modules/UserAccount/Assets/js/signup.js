/**
 * Created by riyad on 1/21/15.
 */

function submit_login(oauth) {

    if (oauth === undefined) {
        oauth=false;
    }
    $('#login_error_msg').html('');
    $('#login_username_alert').html('');
    $('#login_password_alert').html('');

    if ($('#login_username').val() == '') {
        $('#login_username_alert').append('<p>Please enter your User Name</p>');
        $('#login_username').focus();
        return; }

    if ($('#login_password').val() == '') {
        $('#login_password_alert').append('<p>Please enter your Password</p>');
        $('#login_password').focus();
        return; }

    if (oauth === false) {
        login_provide_url = $('#base_url').val() + '/index.php?control=UserAccount&action=login-submit' ;
    }
    else {
        login_provide_url = $('#base_url').val() + '/index.php?control=OAuth&action=' + oauth +'login' ;
    }

    $.ajax({
        type: 'POST',
        url: login_provide_url,
        data: {
            username: $('#login_username').val(),
            password: $('#login_password').val()
        } ,
        dataType: "json",
        success: function(result) {
            if(result.status == true){
                $('#login_success_msg').html("<p>Success! Logging you in...</p>");
                window.location.assign($('#base_url').val() + '/index.php?control=Index&action=show'); }
            else{
                $('#login_error_msg').html("<p>"+result.msg+"</p>");
                $('#login_username').focus();
                return; } }
    });

}

function submit_registration() {
    $('#login_error_msg').html('');
    $('#login_username_alert').html('');
    $('#login_email_alert').html('');
    $('#login_password_alert').html('');
    $('#login_password_match_alert').html('');

    if ($('#login_username').val() == '') {
        $('#login_username_alert').html('&nbsp;&nbsp;Please enter your User Name');
        $('#login_username').focus();
        return;
    }

    if ($('#login_email').val() == '') {
        $('#login_email_alert').html('&nbsp;&nbsp;Please enter your Email');
        $('#login_email').focus();
        return;
    }

    if (!validateEmail($('#login_email').val())) {
        $('#login_email_alert').html('&nbsp;&nbsp;Format is not correct.');
        $('#login_email').focus();
        return;
    }

    if ($('#login_password').val() == '') {
        $('#login_password_alert').html('&nbsp;&nbsp;Please enter your Password');
        $('#login_password').focus();
        return;
    }

    if ($('#login_password_match').val() == '') {
        $('#login_password_match_alert').html('&nbsp;&nbsp;Please enter Password Again');
        $('#login_password_match').focus();
        return;
    }

    if ($('#login_password_match').val() != $('#login_password').val()) {
        $('#login_password_match_alert').html('&nbsp;&nbsp;Password Does Not Match...Try Again');
        $('#login_password_match').val('');
        $('#login_password_match').focus();
        return;
    }



    $.ajax({
        type: 'POST',
        url: $('#base_url').val() + '/index.php?control=UserAccount&action=registration-submit',
        data: {
            username:$('#login_username').val(),
            email:$('#login_email').val(),
            password:$('#login_password').val()
        },
        dataType: "json",
        success: function(result) {
                $('#'+result.id).html('&nbsp;&nbsp;'+result.msg);
                $('#'+result.id).focus();
        }
    });

}

function validateEmail($email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if( !emailReg.test( $email ) ) {
        return false;
    } else {
        return true;
    }
}