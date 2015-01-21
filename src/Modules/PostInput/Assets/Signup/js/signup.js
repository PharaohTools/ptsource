/**
 * Created by riyad on 1/21/15.
 */

function submit_login() {
    $('#login_error_msg').html('');
    $('#login_username_alert').html('');
    $('#login_password_alert').html('');

    if ($('#login_username').val() == '') {
        $('#login_username_alert').html('&nbsp;&nbsp;Please enter your User Name');
        $('#login_username').focus();
        return;
    }

    if ($('#login_password').val() == '') {
        $('#login_password_alert').html('&nbsp;&nbsp;Please enter your Password');
        $('#login_password').focus();
        return;
    }
    $.ajax({
        type: 'POST',
        url: $('#base_url').val() + '/index.php?control=Signup&action=login-submit',
        data: {
            username:$('#login_username').val(),
            password:$('#login_password').val()
        },
        dataType: "json",
        success: function(result)
        {
            if(result.status == true){
                window.location.assign($('#base_url').val() + '/index.php?control=Index&action=show');
            }
            else{
                $('#login_error_msg').html('&nbsp;&nbsp;'+result.msg);
                $('#login_username').focus();
                return;
            }

        }
    });

}
