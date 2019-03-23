<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $channel->getName();
$this->params['breadcrumbs'][] = $this->title;
$jsBody = <<<JS
    $('.btn-copy-link').on('click', function() {
        var container = $(this).closest('li');
        var link = $('a', container).attr('href');
        var tempInput = $('<textarea>').attr({
            class: 'clipboard',
            style: 'margin: -1000px 0 0 -1000px'
        });
        $('body').append(tempInput);
        $('.clipboard').text(link);
        $('.clipboard').select();
        document.execCommand('copy');
        $('.clipboard').remove();
        toastr.info('Link copied');
    });
JS;
$this->registerJs($jsBody);
?>

<div class="site-channel">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="row">
        
        <div class="col-md-12">
            <div style="margin: 0 0 20px 0; padding: 20px 0px; background-color: #333; text-align: center;">
                <img src="https://static-cdn.jtvnw.net/previews-ttv/live_user_<?php echo $channel->getName(); ?>-640x360.jpg" border="0" />
            </div>
        </div>
    
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div style="overflow-x: hidden;">
                <ul class="list-unstyled">
                    <?php foreach ($channel->getPlaylist() as $hls) : ?>
                        <li>
                            <h4><?php echo $hls['inf'][2]; ?>, <?php echo $hls['inf'][5]; ?></h4>
                            <a href="<?php echo $hls['uri']; ?>" style="white-space: nowrap;" target="_blank">
                                <?php echo $hls['uri']; ?>
                            </a>
                            <br><br>
                            <button class="btn btn-dark btn-copy-link">Copy to clipboard</button>
                            <br/><br/>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    
</div>
