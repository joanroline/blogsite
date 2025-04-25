<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class SignupForm extends Model
{
    public $username;
    public $firstname;
    public $lastname;
    public $password;
    public $confirm_password;
    public $email;
    public $gender;
    public $image;

    public function rules()
    {
        return [
            [['firstname',], 'required'],
            [['lastname',], 'required'],
            [['username', 'password', 'confirm_password', 'email', 'gender'], 'required'],
            [['email'], 'string', 'max' => 255],
            ['email', 'email'],
            [['password'], 'string', 'min' => 6],
            [['confirm_password'], 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords must match'],
            [['username'], 'unique', 'targetClass' => 'app\models\User', 'message' => 'This username has already been taken.'],
            ['email', 'email', 'message' => 'Please enter a valid email address'],
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg', 'skipOnEmpty' => true],
            ['email', 'filter', 'filter' => 'strtolower'],
            [['image'], 'safe'],
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->gender = $this->gender;
        $user->setPassword($this->password);

        // Handle image upload
        $uploadedImage = UploadedFile::getInstance($this, 'image');
        if ($uploadedImage) {
            $user->image = file_get_contents($uploadedImage->tempName);
        }

        return $user->save() ? $user : null;
    }
}
