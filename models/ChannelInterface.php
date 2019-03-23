<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

/**
 * ChannelInterface
 *
 * @author amakhin
 */
interface ChannelInterface
{
    /**
     * Getter method for <name> attribute
     *
     * @return string|null name of channel
     */
    public function getName(): ?string;
    
    /**
     * Getter method for <userId> attribute
     *
     * @return string
     */
    public function getUserId(): string;
    
    /**
     * Getter method for <playlist> attribute
     *
     * @return array playlist of channel
     */
    public function getPlaylist(): array;
    
    /**
     * Setter method for <playlist> attribute
     *
     * @param array $playlist of channel
     */
    public function setPlaylist(array $playlist = []): void;
}
