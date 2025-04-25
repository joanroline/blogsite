<?php

namespace app\controllers;


use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Posts;
use app\models\Signup;
use app\models\SignupForm;
use app\models\User;
use app\models\ViewPosts;
use yii\base\Model;
use yii\web\UploadedFile;
use app\models\Comment;
use app\models\Comments;
use app\models\Likes;
use app\models\Reactions;
use app\models\Notifications;
use finfo;
use yii\helpers\Html;
use kartik\mpdf\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /* public function behaviors()
{
    return [
        'access' => [
            'class' => AccessControl::class,
            'only' => ['view_members', 'posts', 'createPosts', 'updatePosts', 'deletePosts'], // actions you want to restrict
            'rules' => [
                [
                    'actions' => ['index', 'view_posts', 'sign_up'], // allow these for everyone
                    'allow' => true,
                ],
                [
                    'actions' => ['Posts'], // Allow createPosts for all logged in users
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'allow' => true,
                    'roles' => ['@'], // '@' means authenticated users
                    'matchCallback' => function ($rule, $action){
                    return Yii::$app->user->identity->role == 'admin';
                    },
                    'actions' => ['view_members', 'posts', 'updatePosts', 'deletePosts'], // Restrict these to admin
                ],
            ],
        ],
    ];
}*/

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $notifications = Notifications::find()->where(['user_id' => Yii::$app->user->id])->orderBy(['created_at' => SORT_DESC])->all();
        if (!Yii::$app->user->isGuest) {
            //retrieve the currently logged-in user's data
            $user = Yii::$app->user->identity;

            // Pass the user data to the view
            return $this->render('index', [
                'user' => $user,
                'posts' => Posts::find()->orderBy(['created_at' => SORT_DESC])->limit(5)->all(),
                'comments' => Comments::find()->all(),
            ]);
        }

        // If the user is not logged in, just show posts
        return $this->render('index', [
            'notifications' => $notifications,
            'posts' => Posts::find()->orderBy(['created_at' => SORT_DESC])->all(),
        ]);
    }

    public function actionBlogSite()
    {

        return $this->render('blog_site');
    }
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->redirect('index');
        }
        return $this->render('sign_up', ['model' => $model]);
    }

    public function actionSaveuser()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->redirect('index');
        }
        return $this->render('saveuser', ['model' => $model]);
    }
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin2()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('index');
        }


        $model->password = '';
        return $this->render('login2', [
            'model' => $model,
        ]);
    }

    /*public function actionPosts()
    {
        $model = new Posts();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Post saved successfully'));
            return $this->redirect(['index']);
        }

        $allposts = Posts::find()->all();
        return $this->render('posts', ['model' => $model, 'allposts' => $allposts]);
    }*/

    public function actionPosts()
    {
        $model = new Posts();


        if ($model->load(Yii::$app->request->post())) {
            $model->coverImageFile = UploadedFile::getInstance($model, 'coverImageFile');

            if ($model->validate()) {
                if ($model->coverImageFile) {
                    // ✅ Save as binary string, not as resource
                    $model->coverimage = file_get_contents($model->coverImageFile->tempName);
                }

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Post created successfully!');
                    return $this->redirect(['site/index']);
                }

                $finfo = new finfo(FILEINFO_MIME_TYPE);
                echo $finfo->buffer(file_get_contents('/full/path/to/sample.jpg'));
            }
        }


        // Fetch all posts for display
        $allposts = Posts::find()->all();
        return $this->render('posts', ['model' => $model, 'allposts' => $allposts]);
    }

    public function actionNotifications()
    {
        $users = User::find()->where(['<>', 'id', Yii::$app->user->id])->all();
        $posts = Posts::find()->orderBy(['created_at' => SORT_DESC])->all();
        $currentUserId = Yii::$app->user->id;

        foreach ($users as $user) {
            foreach ($posts as $post) {
                // Create a new notification for each user-post pair
                $newNotification = new Notifications();
                $newNotification->user_id = $user->id;
                $newNotification->post_id = $post->id;
                $newNotification->save();
            }
        }

        // Mark notifications for current user as read
        foreach ($posts as $post) {
            $postId = $post->id;
            $notifications = Notifications::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->orderBy(['created_at' => SORT_DESC])
                ->all();

            foreach ($notifications as $notification) {

                if ($notification !== null) {
                    $notification->is_read = true;
                    $notification->save();
                } else {
                    Yii::warning("Notification not found for user_id=$currentUserId and post_id=$postId");
                }
            }
        }
        return $this->render('notifications', ['notification' => $notifications]);
        //return $this->redirect(['site/index']);
    }



    public function actionViewPosts()
    {

        $models = Posts::find()->with('author')->orderBy(['id' => SORT_DESC])->limit(10)->all();
        return $this->render('view_posts', ['model' => $models]);

        /*$dataProvider = new ActiveDataProvider([
            'query' => ViewPosts::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10], // Adjust pagination as needed
        ]);

        return $this->render('view_posts', ['dataProvider' => $dataProvider]);*/
    }

    public function actionUpdatePosts($id)
    {
        $model = Posts::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);
            Yii::$app->session->setFlash('success', 'Post updated successfully');
            return $this->redirect(['index']);
        }
        return $this->render('posts', ['model' => $model]);
    }


    public function actionViewPost($id)
    {
        $post = Posts::findOne($id);
        if (!$post) {
            throw new NotFoundHttpException("POst npt found");
        }
        return $this->render('viewpost', ['post' => $post]);
    }

    public function actionDeletePosts($id)
    {
        $model = Posts::findOne($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Post deleted successfully');
        return $this->redirect(['index']);
    }

    public function actionViewMembers()
    {
        // $model = User::find()->orderBy(['id'=>SORT_DESC])->limit(10)->all();
        $model = User::find()->orderBy(['id' => SORT_DESC])->all();

        return $this->render('view_members', ['model' => $model]);
    }

    public function actionMemberspdf()
    {
        $members = User::find()->all();
        //get your Html raw content without any layouts or scripts
        $content = $this->renderPartial('memberspdf', [
            'members' => $members,
            'isPdf' => true
        ]);

        //setup kartik\mpdf\Pdf componet
        $pdf = new Pdf([
            //set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            //A4 paper format
            'format' => Pdf::FORMAT_A4,
            //potrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            //stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            //your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ['Dev Users'],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionMembersexcel()
    {
        $members = User::find()->all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        //Set header row
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'First Name');
        $sheet->setCellValue('C1', 'Last Name');
        $sheet->setCellValue('D1', 'Email');

        //Fill data
        $row =1;
        foreach ($members as $index => $member) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $member->firstname);
            $sheet->setCellValue('C' . $row, $member->lastname);
            $sheet->setCellValue('D' . $row, $member->email);
            $row++;
        }

        // Redirect output to a client’s web browser (Excel)
        $filename = 'Members.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function actionUpdateMembers($id)
    {
        $post = $this->findModel($id);

        if ($post->user_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $model = User::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);
            Yii::$app->session->setFlash('success', 'Member updated successfully');
            return $this->redirect(['view-members']);
        }
        return $this->render('userupdate', ['model' => $model]);
    }

    public function actionViewMember($id)
    {
        $model = User::findOne($id);
        return $this->render('viewmember', ['model' => $model]);
    }



    public function actionDeleteMembers($id)
    {
        $post = $this->findModel($id);

        if ($post->user_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $model = User::findOne($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Member deleted successfully');
        return $this->redirect(['view-members']);
    }

    public function actionMyPosts()
    {
        $created_by = Yii::$app->user->id;
        $posts = Posts::find()->where(['created_by' => $created_by])->with('likes')->all();
        return $this->render('my-posts', ['posts' => $posts,]);
    }

    public function actionComment($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login2']);
        }

        $model = new Comments();
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->post_id = $id;
            $model->save();
        }

        return $this->redirect(['site/index', 'id' => $id]);
    }




    public function actionReply($id)
    {
        $comment = Comments::findOne($id); // The comment you're replying to
        if (!$comment) {
            Yii::$app->session->setFlash('error', 'Comment not found.');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $reply = new Comments();
        if (Yii::$app->request->isPost && $reply->load(Yii::$app->request->post())) {
            $reply->post_id = $comment->post_id;
            $reply->user_id = Yii::$app->user->id;
            $reply->parent_id = $comment->id;
            $reply->created_at = date('Y-m-d H:i:s');

            if ($reply->save()) {
                Yii::$app->session->setFlash('success', 'Reply posted successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to post reply.');
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }


    public function actionLike($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login2']);
        }

        $userId = Yii::$app->user->id;

        $like = Likes::findOne(['post_id' => $id, 'user_id' => Yii::$app->user->id]);

        if ($like) {
            //unlike: delete the existing like
            $like->delete();
        } else {
            //like: create a new like
            $like = new Likes();
            $like->post_id = $id;
            $like->user_id = $userId;
            $like->save();
        }

        return $this->redirect(['site/index', 'id' => $id]);
    }


    // Show profile action
    public function actionProfile()
    {
        // Get the logged-in user
        $user = Yii::$app->user->identity;

        // If the user is not logged in, redirect to the login page
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login2']);
        }

        // Create a model for the user profile form
        $userModel = new User();

        // If the profile form is submitted, validate and update user info
        if ($userModel->load(Yii::$app->request->post()) && $userModel->validate()) {
            // Here you can update the user's details (e.g., profile picture, email, etc.)
            $user->email = $userModel->email;  // Update user's email or other fields

            // Save the updated user data
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Profile updated successfully!');
                return $this->refresh();  // Refresh to show updated profile
            } else {
                Yii::$app->session->setFlash('error', 'There was a problem updating your profile.');
            }
        }

        // Pass user data and the form model to the view
        return $this->render('profile', [
            'user' => $user,
            'userModel' => $userModel,
        ]);
    }

    public function actionEdit()
    {
        $model = new SignupForm();
        $user = Yii::$app->user->identity;

        // Preload data if you want
        $model->firstname = $user->firstname;
        $model->lastname = $user->lastname;
        $model->username = $user->username;
        $model->email = $user->email;
        $model->gender = $user->gender;

        if ($model->load(Yii::$app->request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->image) {
                $user->image = file_get_contents($model->image->tempName);
            }

            $user->firstname = $model->firstname;
            $user->lastname = $model->lastname;
            $user->email = $model->email;
            $user->gender = $model->gender;

            if ($model->password) {
                $user->setPassword($model->password);
            }

            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Profile updated successfully.');
                return $this->redirect(['site/profile']);
            }
        }

        return $this->render('editprofile', ['model' => $model]);
    }









    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
