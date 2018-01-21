
<script type="text/javascript">
    
    $(document).ready(function () {
        
        $('#continue_user_profile').click(function () {
            
            var ajaxUrl = '<?php echo Yii::$app->urlManager->createUrl(['html_generate']); ?>';
            var app_id = '<?php echo $app_id; ?>';
            $.ajax({
                url: ajaxUrl,
                data: {appId: app_id},
                type: "post",
                success: function (response) {
                    $('#html_generate').html(response);
                    $('.canvas_blk').show();
                    $('#html_generate').show();
                    
                    setTimeout(function () {
                        ajax_image_process();
                    }, 1000);
                }
            });


        });
    });

    function ajax_image_process() {
        html2canvas($('#html_generate'), {
            allowTaint: true,
            taintTest: false,
            onrendered: function (canvas) {
                alert('fadsfa');
                //document.getElementById('someBox').appendChild(canv);
                document.body.appendChild(canvas);
                    $('canvas').attr('id', 'canvas');
                $('canvas').attr('class', 'canvas_blk');
                var canvas = document.getElementById("canvas");
                //window.location.href = canvas.toDataURL('image/jpeg');
                var images = canvas.toDataURL("image/jpeg"); //.replace("image/png", "image/octet-stream");
                var file_name = Math.floor(Date.now()) + '.jpeg';
                $("#canvas").remove();

                var ajaxUrl = '<?php echo Yii::$app->urlManager->createUrl('canvas_images_save'); ?>';
                $.ajax({
                    url: ajaxUrl,
                    data: {
                        base64: images,
                        file_name: file_name,
                        app_title: '<?php echo $app_title; ?>',
                        app_description: '<?php echo $app_description; ?>',
                    },
                    type: "post",
                    success: function (response) {
                        response = $.trim(response);
                        $('.canvas_blk').hide();
                        setTimeout(function () {
                            window.location.href = "<?php echo SITE_ABS_PATH.'share_post?id='; ?>"+response;   
                        }, 1000);
                    }
                });
                $('#html_generate').hide();
                $('#canvas').attr('id', 'null');
            }
        });
    }
</script>