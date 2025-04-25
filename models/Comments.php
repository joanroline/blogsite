<?php
namespace app\models;

use yii\db\ActiveRecord;

class Comments extends ActiveRecord
{

    public $parent_id;
    public static function tableName()
    {
        return 'comments';
    }

    public function rules()
    {
        return [
            [['post_id', 'user_id', 'content'], 'required'],
            [['post_id', 'user_id', 'parent_id'], 'integer'],
            [['content'], 'string'],
            [['created_at'], 'safe']
        ];

    }

    public function getReplies()
    {
        return $this->hasMany(Comments::class, ['parent_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
