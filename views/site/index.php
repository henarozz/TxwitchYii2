<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Txwitch Home';

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Txwitch</h1>

        <p class="lead">Simple web application that allows you to extract HLS links from Twitch.tv</p>

        <p><a class="btn btn-lg btn-success" href="<?php echo Url::toRoute(['site/streams']); ?>">Let's try!</a></p>
    </div>

</div>
