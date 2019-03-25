<?php

namespace app\models;

use yii\base\Model;
use app\models\Channel;

/**
 * Class Stream Model
 *
 * @author amakhin
 */
class Stream extends Model
{
    /**
     *
     * @var Channel
     */
    public $channel;
    
    /**
     *
     * @var string
     */
    public $thumbnailUrl;
    
    /**
     *
     * @var string
     */
    public $amountOfViewers;
    
    public function rules(): array
    {
        return [
            ['channel', 'required'],
            [['thumbnailUrl', 'amountOfViewers'], 'safe']
        ];
    }
}
