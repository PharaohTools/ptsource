function submit_registration() {
    $('#login_error_msg').html('');
    $('#login_username_alert').html('');
    $('#login_email_alert').html('');
    $('#login_password_alert').html('');
    $('#login_password_match_alert').html('');

    if ($('#login_username').val() == '') {
        $('#login_username_alert').html('&nbsp;&nbsp;Please enter your User Name');
        $('#login_username').focus();
        return; }

    if ($('#login_email').val() == '') {
        $('#login_email_alert').html('&nbsp;&nbsp;Please enter your Email');
        $('#login_email').focus();
        return; }

    if (!validateEmail($('#login_email').val())) {
        $('#login_email_alert').html('&nbsp;&nbsp;Format is not correct.');
        $('#login_email').focus();
        return; }

    if ($('#login_password').val() == '') {
        $('#login_password_alert').html('&nbsp;&nbsp;Please enter your Password');
        $('#login_password').focus();
        return;  }

    if ($('#login_password_match').val() == '') {
        $('#login_password_match_alert').html('&nbsp;&nbsp;Please enter Password Again');
        $('#login_password_match').focus();
        return; }

    if ($('#login_password_match').val() != $('#login_password').val()) {
        $('#login_password_match_alert').html('&nbsp;&nbsp;Password Does Not Match...Try Again');
        $('#login_password_match').val('');
        $('#login_password_match').focus();
        return; }

    $.ajax({
        type: 'POST',
        url: $('#base_url').val() + '/index.php?control=Signup&action=registration-submit',
        data: {
            username:$('#login_username').val(),
            email:$('#login_email').val(),
            password:$('#login_password').val()
        },
        dataType: "json",
        success: function(result) {
                $('#registration_error_msg').html('&nbsp;&nbsp;'+result.msg);
                $('#registration_error_msg').focus(); }
    });

    alert("reg sent") ;

}

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}