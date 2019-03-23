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
 * Description of Stream
 *
 * @author amakhin
 */
class Stream extends Model
{
    /**
     *
     * @var ChannelInterface
     */
    protected $channel;
    
    /**
     *
     * @var string
     */
    protected $thumbnailUrl;
    
    /**
     *
     * @var string
     */
    protected $amountOfViewers;
    
    /**
     * Stream Model constructor
     *
     * 
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }
    
    /**
     * Getter method for <channel>
     *
     * @return ChannelInterface model
     */
    public function getChannel(): ChannelInterface
    {
        return $this->channel;
    }
    
    /**
     * Setter method for <channel>
     *
     * @param ChannelInterface $channel
     */
    public function setChannel(ChannelInterface $channel): void
    {
        $this->channel = $channel;
    }
    
    /**
     * Getter method for <thumbnailUrl> attribute
     *
     * @return string
     */
    public function getThumbnailUrl(): string
    {
        return $this->thumbnailUrl;
    }
    
    /**
     * Setter method for <thumbnailUrl> attribute
     *
     * @param string $thumbnailUrl
     */
    public function setThumbnailUrl(string $thumbnailUrl): void
    {
        $this->thumbnailUrl = $thumbnailUrl;
    }
    
    /**
     * Getter method for <amountOfViewers> attribute
     *
     * @return string
     */
    public function getAmountOfViewers(): string
    {
        return $this->amountOfViewers;
    }
    
    /**
     * Setter method for <amountOfViewers> attribute
     *
     * @param string $amountOfViewers
     */
    public function setAmountOfViewers(string $amountOfViewers): void
    {
        $this->amountOfViewers = $amountOfViewers;
    }
}
