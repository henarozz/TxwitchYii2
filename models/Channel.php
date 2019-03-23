<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use yii\base\Model;
use app\models\ChannelInterface;

/**
 * Channel Model
 *
 * @author amakhin
 */
class Channel extends Model implements ChannelInterface
{
    /**
     *
     * @var string
     */
    protected $name;
    
    /**
     *
     * @var string
     */
    protected $userId;
    
    /**
     *
     * @var array
     */
    protected $playlist;
    
    /**
     * Channel Model constructor
     *
     * @param string $name of Channel
     * @param string $userId Channel's owner
     */
    public function __construct(string $name, string $userId, array $config = [])
    {
        $this->name = $name;
        $this->userId = $userId;
        
        parent::__construct($config);
    }
    
    /**
     * Getter method for <name> attribute
     *
     * @return string|null name of channel
     */
    public function getName(): ?string
    {
        return $this->name;
    }
    
    /**
     * Getter method for <userId> attribute
     *
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }
    
    /**
     * Getter method for <playlist> attribute
     *
     * @return array playlist of channel
     */
    public function getPlaylist(): array
    {
        return $this->playlist;
    }
    
    /**
     * Setter method for <playlist> attribute
     *
     * @param array $playlist of channel
     */
    public function setPlaylist(array $playlist = []): void
    {
        $this->playlist = $playlist;
    }
}
