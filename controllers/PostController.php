<?php

namespace app\controllers;

use app\models\Posts;
use app\models\Members;
use app\models\User;
use Yii;

class PostController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    
    
    /*public function actionMembers()   
    {
        $model = new Members();
       // dd($model);
        if ($model->load(Yii::$app->request->post()) && $model->save()){
            //dd(Yii::$app->request->post());
            Yii::$app->getSession()->setFlash('success', Yii::t('app','Member saved successfully'));
            return $this->redirect(['view-members']);
        }
        return $this->render('members', ['model'=> $model]);
    }*/

    
   
    
    

    public function actionViewMembers()
    {
        $model = User::find()->orderBy(['id'=>SORT_DESC])->limit(10)->all();

        return $this->render('view_members', ['model'=> $model]);
        
    }

    
}
