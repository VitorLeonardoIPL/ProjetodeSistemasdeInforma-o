<?php

namespace backend\controllers;

use backend\models\UserForm;
use backend\models\UserSearch;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UserController: CRUD de utilizadores com soft delete (delete so muda o status)
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                //controlo de acesso: cada action pede a permissao do RBAC
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'view', 'create', 'update', 'delete', 'restore'],
                            'roles' => ['gerirUtilizadores'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'restore' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new UserForm();
        if ($model->load($this->request->post()) && ($user = $model->save())) {
            return $this->redirect(['view', 'id' => $user->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = new UserForm($this->findModel($id));
        if ($model->load($this->request->post()) && ($user = $model->save())) {
            return $this->redirect(['view', 'id' => $user->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'id' => $id,
        ]);
    }

    //soft delete: a conta nao sai da BD, passa a status apagado
    public function actionDelete($id)
    {
        //ninguem apaga a propria conta
        if ($id == Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'Nao podes apagar a tua propria conta.');

            return $this->redirect(['index']);
        }
        $this->findModel($id)->softDelete();

        return $this->redirect(['index']);
    }

    //reativar uma conta apagada
    public function actionRestore($id)
    {
        $this->findModel($id)->restore();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
