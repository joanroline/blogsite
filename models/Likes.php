<?php

namespace app\models;

use yii\db\ActiveRecord;

class Likes extends ActiveRecord
{
    public static function tableName()
    {
        return 'likes';
    }

    public function rules()
    {
        return [
            [['post_id', 'user_id'], 'required'],
            [['post_id', 'user_id'], 'integer'],
        ];
    }

    public function getPost()
    {
        return $this->belongsTo(Posts::class, ['post_id' => 'id']);
    }
}
