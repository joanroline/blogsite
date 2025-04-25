<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Posts;
use app\models\User;
use Yii;

class WeeklyDigestController extends Controller
{
    public function actionSend()
    {
        // Get date 7 days ago in proper SQL datetime format
        $lastWeek = date('Y-m-d H:i:s', strtotime('-7 days'));

        // Fetch posts created in the last 7 days
        $posts = Posts::find()
            ->where(['>=', 'created_at', $lastWeek])
            ->all();

        if (empty($posts)) {
            echo "No new posts this week.\n";
            return;
        }

        // Get all users (you can refine this to only active/subscribed ones)
        $users = User::find()->all();

        foreach ($users as $user) {
            Yii::$app->mailer->compose('weekly_digest', [
                'user' => $user,
                'posts' => $posts
            ])
            ->setFrom('joanatuheire0@gmail.com')
            ->setTo($user->email)
            ->setSubject('Weekly Digest - New Posts This Week')
            ->send();
        }

        echo "Weekly digest sent to all users.\n";
    }
}
