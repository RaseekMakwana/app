<div id="app_header_block">
    <div class="thumbnail" style="border-bottom: 1px solid #ccc;">
        <?php if (!empty($post_image) && file_exists(POSTS_PICTURE_ABS_ORIGINAL . $post_image)): ?>
            <img src="<?php echo POSTS_PICTURE_URL_ORIGINAL . $post_image; ?>">
        <?php endif; ?> 
    </div>

    <div class="thumbnail" style="border-bottom: 1px solid #ccc;">
        <p style="text-align: center">
            <button onclick="login()" id="continue_facebook" class="btn btn-primary" style="display: none">Continue with Facebook</button>
        <div id="continue_user_profile" class="btn btn-primary" style="display: none">
            <div class=""><i class='fa fa-facebook-official'></i> Continue with </div>
            <div id="fb_profile_name"></div> 
            <div id="fb_profile_pic"></div>
        </div>
        <input type="hidden" id="fb_login_status" value="">
        </p>
    </div>
</div>



<script>
    $(document).ready(function(){
        
        
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
                fb_connect();
            } else if (response.status === 'not_authorized') {
                fb_disconnect();
            } else {
                fb_disconnect();
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
                fb_connect();
            }
        }, {scope: 'email'});
    }

    // getting basic user info
    function getInfo() {
        FB.api('/me', 'GET', {fields: 'first_name,last_name,name,id,picture.width(150).height(150)'}, function (response) {
            document.getElementById('status').innerHTML = "<img src='" + response.picture.data.url + "'>";
        });
    }
    
    function fb_connect(){
        document.getElementById('fb_login_status').value = 'connected';
        $('#continue_facebook').hide();
        $('#continue_user_profile').show();
        FB.api('/me', 'GET', {fields: 'first_name,last_name,name,id,picture.width(150).height(150)'}, function (response) {
            document.getElementById('fb_profile_name').innerHTML = response.last_name;
            document.getElementById('fb_profile_pic').innerHTML = "<img src='" + response.picture.data.url + "'>";
            document.getElementById('fb_login_status').value = 'connected';
        });
    }
    
    function fb_disconnect(){
        document.getElementById('fb_login_status').value = 'not_authorized';
        $('#continue_facebook').show();
        $('#continue_user_profile').hide();
    }
    
</script>