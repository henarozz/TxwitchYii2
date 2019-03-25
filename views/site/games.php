<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Games';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-games">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $q = 0; ?>
    
    <?php foreach($games as $game): ?>
    
    <?php if ($q === 0): ?>
    <div class="row">
    <?php endif; ?>
        
    <?php $q++; ?>
        
        <div class="col-md-4">
            <div style="margin: 0 0 20px 0; padding: 20px 0px; background-color: #333; text-align: center;">
                <img src="<?php echo $game->boxArtUrl; ?>" border="0" />
                <h4><?php echo $game->name; ?></h4>
                <a href="<?php echo Url::toRoute(['site/streams', 'game_id' => $game->id, 'lang' => '']); ?>" class="btn btn-dark btn-sm">Global Top</a>
                <a href="<?php echo Url::toRoute(['site/streams', 'game_id' => $game->id, 'lang' => 'ru']); ?>" class="btn btn-dark btn-sm">Russian Top</a>
            </div>
        </div>
        
    <?php if ($q === 3): ?>
    </div>
    <?php $q = 0; ?>
    <?php endif; ?>
    
    <?php endforeach; ?>
    
    </div>
    
</div>
