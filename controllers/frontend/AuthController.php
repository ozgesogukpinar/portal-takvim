<?php
namespace kouosl\takvim\controllers\frontend;
use yii\helpers\ArrayHelper;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use kouosl\site\models\SignupForm;
use yii\filters\Cors;
/**
 * Site controller
 */
class AuthController extends DefaultController
{
    public function beforeAction($action) {
       
        if ($action->id == 'login') {
            $this->enableCsrfValidation = false;
        } 
        return parent::beforeAction($action);
    }
    
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
                        'only' => ['logout', 'signup','contact','about'],
                        'rules' => [
                            [
                                'actions' => ['signup','contact','about'],
                                'allow' => true,
                                'roles' => ['?'],
                            ],
                            [
                                'actions' => ['logout','contact','about'],
                                'allow' => true,
                                'roles' => ['@'],
                            ],
                     
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
  
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {

        if(Setting::findOne(['setting_key' => 'login'])->value === 'true'){
        $request = Yii::$app->request;
        if ($request->isPost) {

            $model = new LoginForm();
            $response =  $request->post('response');
            if($response == null){
                if ($model->load(Yii::$app->request->post()) && $model->login()) {
                    return $this->goBack();
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
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        if(Setting::findOne(['setting_key' => 'contact'])->value === 'true'){

        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }}
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        if(Setting::findOne(['setting_key' => 'login'])->value === 'true'){

        return $this->render('about');
        }
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($kullanicilar = $model->signup()) {
                if (Yii::$app->getKullanicilar()->login($kullanicilar)) {
                    return $this->goHome();
                }
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
        
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionLang($lang){
        yii::$app->session->set('lang',$lang);
        return $this->goHome();
    }
	
	public function actionDeneme($isim="")
	{
        //echo "Merhaba yii framwork";	
        //$this->layout = "deneme";
        return $this->render("deneme",["ad"=>$isim]);
    }
    
}
