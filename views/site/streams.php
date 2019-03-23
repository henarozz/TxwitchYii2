<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Streams';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-streams">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $q = 0; ?>
    
    <?php foreach($streams as $stream): ?>
    
    <?php
        $channelName = $stream->getChannel()->getName();
        $channelUserId = $stream->getChannel()->getUserId();
    ?>
    
    <?php if ($q === 0): ?>
    <div class="row">
    <?php endif; ?>
        
    <?php $q++; ?>
        
        <div class="col-md-4">
            <div style="margin: 0 0 20px 0; padding: 20px 0px; background-color: #333; text-align: center;">
                <img src="<?php echo $stream->getThumbnailUrl(); ?>" border="0" />
                <h4><?php echo $channelName; ?></h4>
                <p><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $stream->getAmountOfViewers(); ?></p>
                <a href="<?php echo Url::toRoute(['site/channel', 'user_channel' => $channelName, 'user_id' => $channelUserId]); ?>" class="btn btn-dark btn-sm">Get HLS links</a>
            </div>
        </div>
        
    <?php if ($q === 3): ?>
    </div>
    <?php $q = 0; ?>
    <?php endif; ?>
    
    <?php endforeach; ?>
    
    </div>
    
</div>
