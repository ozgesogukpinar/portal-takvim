<?php
namespace kouosl\takvim\controllers\backend;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use kouosl\takvim\models\LoginForm;
use \kouosl\takvim\models\Setting;

/**
 * Site controller
 */
class AuthController extends DefaultController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
       
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['login', 'error','lang'],
                            'allow' => true,
                        ],
                        [
                            'actions' => ['logout', 'index'],
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
                ]
        ]);
       
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    public function beforeAction($action) {
        
      
        if ($action->id == 'login') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionKayit()
    {
        return $this->render('kayit');
    }
   
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {

            $model = new LoginForm();
            $response =  $request->post('response');
            if($response == null){
                if ($model->load(Yii::$app->request->post()) && $model->login()) {
                    //return $this->goBack();
                    return $this->redirect(['/takvim/takvim/agiris']);
                } else {
                    return $this->render('login', [
                        'model' => $model,
                    ]);
                }
            }
            else {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                if($model->load(Yii::$app->getRequest()->getBodyParams(),'') && $model->login())
                    return ['access_token' => Yii::$app->user->identity->getAuthKey(),'status' => true];
                else
                    return ['access_token' => '','status' => false];

            }
        }
        else{
            if (!Yii::$app->user->isGuest) {
                return $this->goHome();
            }
    
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->goBack();
            } else {
                return $this->render('login', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['/takvim/takvim/giris']);
        //return $this->goHome();
    }

    public function actionLang($lang){
        
       yii::$app->session->set('lang',$lang);
        return $this->goHome();
    }
}
