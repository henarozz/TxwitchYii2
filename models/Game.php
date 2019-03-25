<?php

namespace app\models;

use yii\base\Model;

/**
 * Class Game Model
 *
 * @author amakhin
 */
class Game extends Model
{
    /**
     *
     * @var string
     */
    public $id;
    
    /**
     *
     * @var string
     */
    public $name;
    
    /**
     *
     * @var string
     */
    public $boxArtUrl;
    
    public function rules(): array
    {
        return [
            [['id', 'name'], 'required'],
            ['boxArtUrl', 'safe']
        ];
    }
}
