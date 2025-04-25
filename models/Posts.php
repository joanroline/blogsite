<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use app\models\Comments;
use app\models\Reactions;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $created_at
 * @property resource|null $coverimage
 */
class Posts extends ActiveRecord
{

    public $coverImageFile;
    public $tags;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['title', 'description'], 'string'],
            [['created_at'], 'safe'],
            [['created_by'], 'integer'],
            [['tags'], 'safe'],
            [['coverImage'], 'safe'],
            [['coverImageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'coverImage' => 'Cover Image',
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_by = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }

    public function getComments()
    {
        return $this->hasMany(Comments::class, ['post_id' => 'id'])->orderBy(['created_at' => SORT_DESC]);
    }

    public function getCommentCount()
    {
        return $this->getComments()->count();
    }

    public function getReactions()
    {
        return $this->hasMany(Reactions::class, ['post_id' => 'id']);
    }

    public function getReactionCount($emoji)
    {
        return $this->getReactions()->andWhere(['emoji' => $emoji])->count();
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    // In the Posts model (app\models\Posts)
    public function getLikes()
    {
        return $this->hasMany(Likes::class, ['post_id' => 'id']);
    }

    public function getNotifications()
    {
        return $this->hasMany(Notifications::class, ['post_id' => 'id']);
    }
}
