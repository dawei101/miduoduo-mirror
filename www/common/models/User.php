<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
use common\BaseActiveRecord;
use common\models\WeichatUserInfo;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property string $created_time
 * @property string $updated_time
 * @property string $name
 * @property string $is_staff
 */
class User extends BaseActiveRecord implements IdentityInterface
{

    public static $STATUSES = [
        'ACTIVE' => 0,
        'DELETE' => 10,
    ];
    public static $STATUS_LABELS = [0=>'正常',
        10=>'已删除'];


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['status', 'invited_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['username', 'name'], 'string', 'max' => 200],
            [['password_hash', 'password_reset_token', 'email', 'access_token'], 'string', 'max' => 500],
            [['auth_key'], 'string', 'max' => 1000],
            [['username'], 'unique'],
            ['status', 'default', 'value' => static::$STATUSES['ACTIVE']],
            ['status', 'in', 'range' => array_values(static::$STATUSES)],
            ['username', 'match', 'pattern'=>'/^1[345789]\d{9}$/',
                'message'=>'手机号不正确，目前仅支持中国大陆手机号.'],
            ['is_staff', 'default', 'value'=>false],
            ['invited_by', 'default', 'value'=>0],
        ];
    }


    public static function createUserWithPhonenum($phonenum, $invited_by=0){
        $user = new User;
        $user->username = $phonenum;
        if ($invited_by && static::findIdentity($invited_by)){
            $user->invited_by = $invited_by;
        }
        $user->setPassword(rand(10000000, 99999999));
        if ($user->save()){
            return $user;
        }
        return false;
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '手机号',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => '邮箱',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'status' => '状态',
            'created_time' => '创建时间',
            'updated_time' => '更新时间',
            'name' => '姓名',
            'invited_by' => '邀请码',
        ];
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => static::$STATUSES['ACTIVE']]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        if ($token && strlen($token)>0){
            return static::findOne(['access_token' => $token]);
        }
        return null;
    }

    public function generateAccessToken()
    {
        $this->access_token= Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => static::$STATUSES['ACTIVE']]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => static::$STATUSES['ACTIVE'],
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
        return $this->password_reset_token;
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function fields()
    {
        return [

            'id', 'username',
            'email' , 'status' , 'created_time' , 'updated_time',
            'name' , 'is_staff'
        ];
    }

    public function getResume(){
        
        return $this->hasOne(Resume::className(), ['user_id' => 'id']);
    }

    public function getWeichat(){
        return $this->hasOne(WeichatUserInfo::className(),['userid' => 'id']);
    }


}
