<?php

namespace app\models;

use app\models\Posts;
use yii\db\ActiveRecord;

class Reactions extends ActiveRecord
{
    public static function tableName()
    {
        return 'reactions';
    }

    public function rules()
    {
        return [
            [['user_id', 'post_id', 'emoji'], 'required'],
            [['user_id', 'post_id'], 'integer'],
            [['emoji'], 'string', 'max' => 10],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getPost()
    {
        return $this->hasOne(Posts::class, ['id' => 'post_id']);
    }

    public function getReactions()
    {
        return $this->hasMany(Reactions::class, ['post_id' => 'id']);
    }

    public function getReactionCount($emoji)
    {
        return $this->getReactions()->andWhere(['emoji' => $emoji])->count();
    }
}
