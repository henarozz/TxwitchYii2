<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use yii\base\Model;

/**
 * Game Model
 *
 * @author amakhin
 */
class Game extends Model
{
    /**
     *
     * @var string
     */
    protected $id;
    
    /**
     *
     * @var string
     */
    protected $name;
    
    /**
     *
     * @var string
     */
    protected $boxArtUrl;
    
    /**
     * Game Model constructor
     *
     * @param string $id
     * @param string $name
     */
    public function __construct(string $id, string $name, array $config = [])
    {
        $this->id = $id;
        $this->name = $name;
        
        parent::__construct($config);
    }
    
    /**
     * Getter method for <id> attribute
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
    
    /**
     * Getter method for <name> attribute
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * Getter method for <boxArtUrl> attribute
     *
     * @return string
     */
    public function getBoxArtUrl(): string
    {
        return $this->boxArtUrl;
    }
    
    /**
     * Setter method for <boxArtUrl> attribute
     *
     * @param string $url
     */
    public function setBoxArtUrl(string $url): void
    {
        $this->boxArtUrl = $url;
    }
}
