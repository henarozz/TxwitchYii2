<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use GuzzleHttp\Client as HttpClient;
use app\components\TxwitchApiClient;
use app\models\Game;
use app\models\Channel;
use app\models\Stream;

class SiteController extends Controller
{    
    private $txwitchApiClient;
    
    public function __construct($id, $module, $config = [])
    {
        $this->txwitchApiClient = new TxwitchApiClient(
                Yii::$app->params['twitch'], 
                new HttpClient(['verify' => false])
            );
        
        parent::__construct($id, $module, $config);
    }


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {   
        return $this->render('index', []);
    }
    
    /**
     * Displays games.
     *
     * @return string
     */
    public function actionGames()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        
        $this->txwitchApiClient->setThumbSize(['width' => 240, 'height' => 320]);
        
        $topGames = $this->txwitchApiClient->getTopGames();
        
        $games = [];
        
        foreach ($topGames as $game) {
            $gameModel = new Game();
            $gameModel->id = $game['id'];
            $gameModel->name = $game['name'];
            $gameModel->boxArtUrl = $game['box_art_url'];
            $games[] = $gameModel;
        }
        
        return $this->render('games', [
            'games' => $games
        ]);
    }
    
    /**
     * Displays streams.
     *
     * @return string
     */
    public function actionStreams($game_id = '', $lang = '')
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        
        $this->txwitchApiClient->setThumbSize(['width' => 320, 'height' => 180]);
        
        $topStreams = $this->txwitchApiClient->getActiveStreams($game_id, $lang);
        
        $streams = [];
        
        foreach ($topStreams as $stream) {
            $channelModel = new Channel();
            $channelModel->name = $stream['channel_name'];
            $channelModel->userId = $stream['user_id'];
            $streamModel = new Stream();
            $streamModel->channel = $channelModel;
            $streamModel->thumbnailUrl = $stream['thumbnail_url'];
            $streamModel->amountOfViewers = $stream['viewer_count'];

            $streams[] = $streamModel;
        }
        
        return $this->render('streams', [
            'streams' => $streams
        ]);
    }
    
    /**
     * Displays channel.
     *
     * @return string
     */
    public function actionChannel($user_channel = '', $user_id = '')
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        
        try {
            $playlist = $this->txwitchApiClient->getChannelPlaylist($user_channel);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            throw new \yii\web\NotFoundHttpException("Channel is not available.");
        }
        
        $channelModel = new Channel();
        $channelModel->name = $user_channel;
        $channelModel->userId = $user_id;
        $channelModel->playlist = $playlist;
        
        return $this->render('channel', [
            'channel' => $channelModel
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
