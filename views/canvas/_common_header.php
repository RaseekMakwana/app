<div id="app_header_block">
    <div class="thumbnail" style="border-bottom: 1px solid #ccc;">
        <?php if (!empty($post_image) && file_exists(POSTS_PICTURE_ABS_ORIGINAL . $post_image)): ?>
            <img src="<?php echo POSTS_PICTURE_URL_ORIGINAL . $post_image; ?>">
        <?php endif; ?> 
    </div>

    <div class="thumbnail" style="border-bottom: 1px solid #ccc;">
        <p style="text-align: center">
            <button onclick="login()" id="continue_facebook" class="btn btn-primary">Continue with Facebook</button>
        <div id="continue_user_profile" class="btn btn-primary">Continue with <div id="fb_profile_name"></div> <div id="fb_profile_pic"></div>
        </div>
        <input type="hidden" id="fb_login_status" value="">
        </p>
    </div>
</div>



<script>
    $(document).ready(function(){
       var fb_status = $('#fb_login_status').val();
       if(fb_status == 'connected'){
           $('#continue_facebook').hide();
           $('#continue_user_profile').show();
       } else {
           $('#continue_facebook').show();
           $('#continue_user_profile').hide();
       }
       
    });
    
    // initialize and setup facebook js sdk
    window.fbAsyncInit = function () {
        FB.init({
            appId: '727081760799378',
            xfbml: true,
            version: 'v2.5'
        });
        FB.getLoginStatus(function (response) {
            if (response.status === 'connected') {
                document.getElementById('fb_login_status').value = 'connected';
            } else if (response.status === 'not_authorized') {
                document.getElementById('fb_login_status').value = 'disconnected'
            } else {
                document.getElementById('fb_login_status').value = 'disconnected';
            }
        });
    };
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    // login with facebook with extra permissions
    function login() {
        FB.login(function (response) {
            if (response.status === 'connected') {
                ajax_login_status('connected');

                FB.api('/me', 'GET', {fields: 'first_name,last_name,name,id,picture.width(150).height(150)'}, function (response) {
                    document.getElementById('status').innerHTML = "<img src='" + response.picture.data.url + "'>";
                    document.getElementById('fb_login_status').value = 'connected';
                });
            }
        }, {scope: 'email'});
    }

    function ajax_login_status(status) {
        var ajaxUrl = '<?php echo Yii::$app->urlManager->createUrl(['fb_login_generate']); ?>';
        $.ajax({
            url: ajaxUrl,
            type: 'post',
            data: {status: status},
            success: function (response) {

            }
        });

    }

    // getting basic user info
    function getInfo() {
        FB.api('/me', 'GET', {fields: 'first_name,last_name,name,id,picture.width(150).height(150)'}, function (response) {
            document.getElementById('status').innerHTML = "<img src='" + response.picture.data.url + "'>";
        });
    }
</script>