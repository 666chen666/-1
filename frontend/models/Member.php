<?php

namespace frontend\models;

use Yii;
use yii\web\IdentityInterface;
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $tel
 * @property string $auth_key
 * @property integer $status
 * @property integer $addtime
 * @property integer $last_login_time
 * @property integer $last_login_ip
 */
class Member extends \yii\db\ActiveRecord implements IdentityInterface
{

    public $repassword;
    public $telcode;
    public $code;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email', 'tel',], 'required'],
            [['status', 'addtime', 'last_login_time', 'last_login_ip'], 'integer'],
            [['username', 'password', 'email',], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 11],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['email'],'email'],
            [['code'],'captcha'],
            [['repassword'],'compare','compareAttribute'=>'password','message'=>'两次密码不一致'],
            [['telcode'],'validateTelcode']
        ];
    }

    public function validateTelcode(){
        $code = Yii::$app->session->get('tel_'.$this->tel);
        if($code != $this->telcode){
            $this->addError('telcode','手机验证码不正确');
        }

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名:',
            'password' => '密码:',
            'email' => '邮箱:',
            'tel' => '电话:',
            'auth_key' => 'Auth Key',
            'status' => '状态:-1删除,0禁用，1正常',
            'addtime' => '注册时间',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录IP',
            'repassword'=>'确认密码:',
            'telcode'=>'短信验证码',
            'code'=>'验证码',
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key==$authKey;
    }

    public function Sendcode($tel,$code){
        $config = [
            'app_key'    => '23747100',
            'app_secret' => '084ef9057090ed89aa20aba03f84ea49',
            // 'sandbox'    => true,  // 是否为沙箱环境，默认false
        ];

        $client = new Client(new App($config));
        $req = new AlibabaAliqinFcSmsNumSend;

        $req->setRecNum($tel)
            ->setSmsParam([
                'content' => $code
            ])
            ->setSmsFreeSignName('JW的梦想')
            ->setSmsTemplateCode('SMS_60820209');

        $resp=$client->execute($req);
    }
}
