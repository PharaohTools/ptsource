/**
 * Created by riyad on 1/21/15.
 */

function submit_ldap() {
    $('#login_error_msg').html('');
    $('#login_servername_alert').html('');
    $('#login_username_alert').html('');
    $('#login_password_alert').html('');


    if ($('#login_servername').val() == '') {
        $('#login_servername_alert').html('&nbsp;&nbsp;Please Enter your Server Name');
        $('#login_servername').focus();
        return;
    }

    if ($('#login_dn').val() == '') {
        $('#login_dn_alert').html('&nbsp;&nbsp;Please Enter your Login DN Name');
        $('#login_dn').focus();
        return;
    }

    if ($('#login_password').val() == '') {
        $('#login_password_alert').html('&nbsp;&nbsp;Please Enter your Password');
        $('#login_password').focus();
        return;
    }
    $.ajax({
        type: 'POST',
        url: $('#base_url').val() + '/index.php?control=ldap&action=ldap-submit',
        data: {
            servername:$('#login_servername').val(),
            username:$('#login_dn').val(),
            password:$('#login_password').val()
        },
        dataType: "json",
        success: function(result)
        {
           console.log(result);
          /*$('#'+result.id).html('&nbsp;&nbsp;'+result.msg);
          $('#'+result.id).focus();*/

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

