<?php

return [
    'adminEmail' => 'admin@example.com',
    'twitch' => [
        'clientId' => '',
        'usherUrl' => 'https://usher.twitch.tv/api/channel/hls/{user_channel}.m3u8?player=twitchweb'.
                            '&token={token}'.
                            '&sig={sig}'.
                            '&$allow_audio_only=true&allow_source=true&type=any&p={random}',
        'tokenUrl' => 'https://api.twitch.tv/api/channels/{user_channel}/access_token?client_id={clientId}',
        'gameUrl' => 'https://api.twitch.tv/helix/games/top?first=100',
        'streamUrl' => 'https://api.twitch.tv/helix/streams?first=100',
        'thumbSize' => ['width' => 320, 'height' => 240]
    ]
];
