<div class="container">

        <?php if($pageVars["route"]["action"] == "login"){ ?>
            <div class="col-sm-8 col-md-9 clearfix main-container">
                <h2 class="text-uppercase text-light"><a href="/"> Phrankinsense - Pharaoh Tools </a></h2>
                <div class="row clearfix no-margin">
                    <h5 class="text-uppercase text-light" style="margin-top: 15px;">
                        Login
                    </h5>
                    <p style="color: #ff6312; margin-left: 137px;" id="login_error_msg"></p>
                    <form class="form-horizontal custom-form">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label text-left">User Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="login_username" placeholder="User Name">
                                <span style="color:#FF0000;" id="login_username_alert"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label text-left">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="login_password" placeholder="Password">
                                <span style="color:#FF0000;" id="login_password_alert"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" onclick="submit_login();" class="btn btn-info">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
                <p>
                    ---------------------------------------<br/>
                    Visit www.pharaohtools.com for more
                </p>

            </div>
        <?php }?>




    </div>

</div><!-- /.container -->
<script>
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
            url: $('#base_url').val() + '/index.php?control=Signup&action=login_submit',
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
</script>
