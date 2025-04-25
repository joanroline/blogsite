<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "members".
 *
 * @property int $id
 * @property string $username
 * @property string $fname
 * @property string $lname
 * @property string $created_at
 * @property string|null $created_by
 * @property string $password
 * @property string $gender
 * @property string $email
 */
class ViewMembers extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'members';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_by'], 'default', 'value' => null],
            [['username', 'fname', 'lname', 'password', 'gender', 'email'], 'required'],
            [['username', 'fname', 'lname', 'created_by', 'password', 'gender', 'email'], 'string'],
            [['created_at'], 'safe'],
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
            'fname' => 'Fname',
            'lname' => 'Lname',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'password' => 'Password',
            'gender' => 'Gender',
            'email' => 'Email',
        ];
    }

}
