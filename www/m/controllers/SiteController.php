<?php
namespace m\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use m\MBaseController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\models\LoginWithDynamicCodeForm;

use m\models\PasswordResetRequestForm;
use m\models\ResetPasswordForm;
use m\models\SignupForm;
use m\models\ContactForm;

use common\models\Task;
use common\models\Resume;
use common\models\District;
use common\models\ConfigRecommend;

/**
 * Site controller
 */
class SiteController extends MBaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
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
            ],
        ];
    }

    public function actionIndex()
    {
        //只有北京
        $city_id    = 3;

        // 查询出需要展示的 gids
        $gid        = ConfigRecommend::find()->where(['type'=>1,'city_id'=>$city_id])->limit(10)->asArray()->addOrderBy(['display_order'=>SORT_DESC])->all();
        $gids       = '';
        foreach( $gid as $key => $value ){
            $gids   .= $value['task_id'].',';
        }
        $gids   = trim($gids,',');
        if($gids){

            // 查询数据显示
            $query = Task::find()->with('city')->with('district');
            $query = $query->where('`gid` in('.$gids.')')
                //->addOrderBy(['id'=>SORT_DESC])
                ->limit(5);
                ;
            $city = District::findOne($city_id);
            //print_r( $query->all() );exit;
            return $this->render('index', 
                ['tasks'=>$query->all(),
                 'city'=>$city,
                ]);

            return $this->render('index');
        }else{
            //只有北京
            $city_id = 3;
            $query = Task::find()->with('city')->with('district');
            $query = $query->where(['city_id'=>$city_id])
                ->addOrderBy(['id'=>SORT_DESC])
                ->limit(5);
                ;
            $city = District::findOne($city_id);
            return $this->render('index', 
                ['tasks'=>$query->all(),
                 'city'=>$city,
                ]);

            return $this->render('index');
        }
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
