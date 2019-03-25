<?php

namespace app\models;

use yii\base\Model;

/**
 * Class Channel Model
 *
 * @author amakhin
 */
class Channel extends Model
{
    /**
     *
     * @var string
     */
    public $name;
    
    /**
     *
     * @var string
     */
    public $userId;
    
    /**
     *
     * @var array
     */
    public $playlist;
    
    public function rules(): array
    {
        return [
            [['name', 'userId'], 'required'],
            ['playlist', 'safe']
        ];
    }
}
