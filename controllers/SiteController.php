<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Alumno;
use app\models\DocumentoGenerado;
use app\models\AvanceAlumno;
use app\models\User;

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
        $model = new \app\models\Alumno();
        $alumnoEncontrado = null;
        $searchPerformed = false;

        // Verificar si se está realizando una búsqueda
        if (Yii::$app->request->get('Alumno')) {
            $matricula = Yii::$app->request->get('Alumno')['matricula'] ?? '';
            
            if (!empty($matricula)) {
                $searchPerformed = true;
                $alumnoEncontrado = Alumno::find()->where(['matricula' => $matricula])->one();
                
                if ($alumnoEncontrado === null) {
                    Yii::$app->session->setFlash('error', "No se encontró ningún alumno con la matrícula: $matricula");
                }
            }
        }

        // Obtener estadísticas
        $totalAlumnos = Alumno::find()->count();
        $totalDocumentos = DocumentoGenerado::find()->count();
        $totalRequisitos = AvanceAlumno::find()
            ->where(['completado' => 1])
            ->count();

        return $this->render('index', [
            'model' => $model,
            'alumnoEncontrado' => $alumnoEncontrado,
            'searchPerformed' => $searchPerformed,
            'totalAlumnos' => $totalAlumnos,
            'totalDocumentos' => $totalDocumentos,
            'totalRequisitos' => $totalRequisitos
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        
        if ($model->load(Yii::$app->request->post())) {
            // Debug: ver qué está llegando
            Yii::debug('Username: ' . $model->username);
            Yii::debug('Password: ' . $model->password);
            
            $user = User::findByUsername($model->username);
            if ($user) {
                Yii::debug('Usuario encontrado: ' . $user->username);
                Yii::debug('Password hash: ' . $user->password_hash);
                Yii::debug('Validation: ' . ($user->validatePassword($model->password) ? 'true' : 'false'));
            } else {
                Yii::debug('Usuario NO encontrado');
            }
            
            if ($model->login()) {
                Yii::debug('Login exitoso');
                return $this->goBack();
            } else {
                Yii::debug('Login fallido - Errores: ' . print_r($model->errors, true));
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
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