<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $email
 * @property string|null $gender
 * @property resource|null $image
 */
class User extends ActiveRecord implements IdentityInterface
{

    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'email', 'gender', 'image'], 'default', 'value' => null],
            [['username', 'password'], 'required'],
            [['password', 'firstname', 'lastname', 'email', 'gender', 'image',], 'string'],
            [['username'], 'string', 'max' => 255],
            [['username'], 'unique'],
            ['firstname', 'match', 'pattern' => '/^[A-Z][a-zA-Z]*$/', 'message' => 'Name must start with a capital letter and contain only letters.'],
            ['lastname', 'match', 'pattern' => '/^[A-Z][a-zA-Z]*$/', 'message' => 'Name must start with a capital letter and contain only letters.'],
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg', 'skipOnEmpty' => true],
            ['email', 'email', 'message' => 'Please enter a valid email address'],
            ['email', 'email'],
            [['image'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'email' => 'Email',
            'gender' => 'Gender',
            'image' => 'Image',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }


    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    //Not there

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    public function getProfile()
    {
        return $this->hasOne(User::class, ['user_id']);
    }

    public function getImageUrl()
{
    return Yii::getAlias('@web/web/downloads/' . ($this->image ?: 'default.png'));
}

}
