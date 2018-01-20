<div class="row">
    <?php foreach ($posts as $key => $val): ?>
        <div class="col-sm-4 col-lg-4 col-md-4">
            <div class="thumbnail">
                <a href="<?php echo Yii::$app->urlManager->createUrl(['canapp', 'cover' => $val->slug]); ?>">
                    <img src="<?php echo POSTS_PICTURE_URL_ORIGINAL.$val->image; ?>" style="width: 100%" alt="">
                    <div class="caption text-center">
                        <h3><?php echo $val->title; ?></h3>
                        <p><?php echo $val->description; ?></p>
                    </div>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
    
</div>
