<?php
/**
 * Txwitch
 *
 * @author Alexander Makhin <henarozz@gmail.com>
 */
namespace app\components;

use yii\base\BaseObject;
use GuzzleHttp\ClientInterface as HttpClientInterface;

/**
 * TxwitchApiClient Class
 *
 * @package app\components
 */
class TxwitchApiClient extends BaseObject
{
    /**
     *
     * @var string
     */
    private $clientId;
    
    /**
     *
     * @var HttpClientInterface
     */
    private $httpClient;
    
    /**
     *
     * @var string
     */
    protected $usherUrl;
    
    /**
     *
     * @var string
     */
    protected $tokenUrl;
    
    /**
     *
     * @var string
     */
    protected $gameUrl;
    
    /**
     *
     * @var string
     */
    protected $streamUrl;
    
    /**
     *
     * @var array
     */
    protected $thumbSize;

    /**
     * TwitchAPI constructor
     *
     * @param array $settings
     * @param HttpClientInterface $httpClient
     */
    public function __construct(array $settings, HttpClientInterface $httpClient, array $config = [])
    {
        $this->clientId = $settings['clientId'];
        $this->httpClient = $httpClient;
        $this->usherUrl = $settings['usherUrl'];
        $this->tokenUrl = str_replace('{clientId}', $this->clientId, $settings['tokenUrl']);
        $this->gameUrl = $settings['gameUrl'];
        $this->streamUrl = $settings['streamUrl'];
        $this->thumbSize = $settings['thumbSize'];
        
        parent::__construct($config);
    }
    
    /**
     * Method to get thumb size (width, height)
     *
     * @return array
     */
    public function getThumbSize(): array
    {
        return $this->thumbSize;
    }
    
    /**
     * Method to set thumb size (width, height)
     *
     * @param array $thumbSize
     */
    public function setThumbSize(array $thumbSize = []): void
    {
        $this->thumbSize = $thumbSize;
    }
    
    /**
     * Method to get twitch top games (limit 100 from gameUrl)
     *
     * @return array
     */
    public function getTopGames(): array
    {
        $requestUrl = $this->gameUrl;
        
        $response = $this->httpClient->request(
                'GET', 
                $requestUrl, 
                ['headers' => ['Client-ID' => $this->clientId]]
            );
        $responseBody = $response->getBody();
        $responseContents = $responseBody->getContents();
        $responseData = json_decode($responseContents, true);
        
        foreach ($responseData['data'] as $key => $game) {
            $boxArtUrlOrig = $game['box_art_url'];
            $boxArtUrl = str_replace(
                    ['{width}', '{height}'], 
                    [
                        $this->thumbSize['width'], 
                        $this->thumbSize['height']
                    ], 
                    $boxArtUrlOrig
                );
            $responseData['data'][$key]['box_art_url'] = $boxArtUrl;
        }

        return $responseData['data'];
    }
    
    /**
     * Method-helper to get channel name from thumbnail url
     *
     * @param string $thumbnailUrl
     * @return string|null
     */
    private function getChannelName(string $thumbnailUrl): ?string
    {
        if (empty($thumbnailUrl)) {
            return null;
        }
        
        $channelName = null;
        $match = [];
        
        if (preg_match('/live_user_(.*?)-{width/', $thumbnailUrl, $match) === 1) {
            $channelName = $match[1];
        }
        
        return $channelName;
    }
    
    /**
     * Method to get active streams
     *
     * @param string $gameId
     * @param string $lang
     * @return array
     */
    public function getActiveStreams(?string $gameId = '', ?string $lang = ''): array
    {
        $queryUrl = '';
        $queryUrl.= !empty($gameId) ? '&game_id=' . $gameId : '';
        $queryUrl.= !empty($lang) ? '&language=' . $lang : '';
        
        $requestUrl = $this->streamUrl . $queryUrl;
        
        $response = $this->httpClient->request('GET', $requestUrl, ['headers' => ['Client-ID' => $this->clientId]]);
        $responseBody = $response->getBody();
        $responseContents = $responseBody->getContents();
        $responseData = json_decode($responseContents, true);
        
        foreach ($responseData['data'] as $key => $stream) {
            $thumbnailUrlOrig = $stream['thumbnail_url'];
            $channelName = $this->getChannelName($thumbnailUrlOrig);
            $responseData['data'][$key]['channel_name'] = $channelName;
            
            $thumbnailUrl = str_replace(
                    ['{width}', '{height}'],
                    [
                        $this->thumbSize['width'], 
                        $this->thumbSize['height']
                    ],
                    $thumbnailUrlOrig
                );
            
            $responseData['data'][$key]['thumbnail_url'] = $thumbnailUrl;
        }
        
        return $responseData['data'];
    }
    
    /**
     * Method-helper to get API token and signature
     *
     * @param string $channelName
     * @return array
     */
    private function getChannelTokenAndSignature(string $channelName): array
    {
        $requestUrl = str_replace('{user_channel}', $channelName, $this->tokenUrl);
        
        $response = $this->httpClient->request('GET', $requestUrl, ['headers' => ['Client-ID' => $this->clientId]]);
        $responseBody = $response->getBody();
        $responseContents = $responseBody->getContents();
        $responseData = json_decode($responseContents, true);
        
        return $responseData;
    }
    
    /**
     * Method to get playlist of channel
     *
     * @param type $channelName
     * @return array
     */
    public function getChannelPlaylist(string $channelName): array
    {
        $tokenAndSignature = $this->getChannelTokenAndSignature($channelName);
        
        $usherUrl = $this->usherUrl;
        $random = rand(0, 1E7);
        
        $requestUrl = str_replace(
                ['{user_channel}', '{token}', '{sig}', '{random}'],
                [$channelName, $tokenAndSignature['token'], $tokenAndSignature['sig'], $random],
                $usherUrl
            );
        
        $response = $this->httpClient->request('GET', $requestUrl, ['headers' => ['Client-ID' => $this->clientId]]);
        $responseBody = $response->getBody();
        $responseContents = $responseBody->getContents();
        $responseData = explode("\n", $responseContents);
        
        $playlist = [];
        $i = 0;
        
        /** @todo need to refactoring EXTM3U parse algorithm using github/chrisyue/php-m3u8 */
        foreach ($responseData as $row) {
            if (substr_count($row, '#EXT-X-STREAM-INF:') > 0) {
                $row = str_replace('#EXT-X-STREAM-INF:', '', $row);
                $rowArray = explode(',', $row);
                $playlist[$i]['inf'] = $rowArray;
            }
            if (substr_count($row, 'http') > 0) {
                $playlist[$i]['uri'] = $row;
                $i++;
            }
        }
        
        return $playlist;
    }
}
