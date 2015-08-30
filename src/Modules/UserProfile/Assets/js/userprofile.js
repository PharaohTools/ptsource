function changePassword() {
    rurl = $('#base_url').val() + '/index.php?control=UserManager&action=changepassword&output-format=JSON' ;
    console.log(rurl) ;
    
    $('#old_password').html('');
    $('#new_password').html('');
    $('#new_password_match').html('');

    $('#old_password_alert').html('');
    $('#new_password_alert').html('');
    $('#new_password_match_alert').html('');
    
    $('#password_match_error').html('');
    
    if ($('#old_password').val() == '') {
        $('#old_password_alert').html('&nbsp;&nbsp;Please enter your old password');
        $('#old_password').focus();
        return; }

    if ($('#new_password').val() == '') {
        $('#new_password_alert').html('&nbsp;&nbsp;Please enter your new password');
        $('#new_password').focus();
        return; }

    if ($('#new_password_match').val() == '') {
        $('#new_password_match_alert').html('&nbsp;&nbsp;Please enter new password Again');
        $('#new_password_match').focus();
        return; }

    if ($('#new_password_match').val() != $('#new_password').val()) {
        $('#password_match_error').html('&nbsp;&nbsp;Password Does Not Match...Try Again');
        $('#new_password_match').val('');
        $('#new_password_match').focus();
        return; }

    $.ajax({
        type: 'POST',
        url: rurl,
        data: {
            oldPassword:$('#old_password').val(),
            newPassword:$('#new_password').val()
        },
        dataType: "json",
        success: function(result) { console.log(result);
            $('#form_alert').html('&nbsp;&nbsp;'+result.msg);
            $('#form_alert').focus(); },
        error: function(result, textStatus, errorThrown) { console.log(result);
            $('#password_error_msg').html('&nbsp;&nbsp;'+textStatus+' '+errorThrown+' '+result.msg);
            $('#password_error_msg').focus(); }

    });
}
