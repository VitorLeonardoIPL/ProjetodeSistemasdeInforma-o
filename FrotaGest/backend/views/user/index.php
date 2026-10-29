<?php

use common\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Utilizadores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger"><?= Html::encode(Yii::$app->session->getFlash('error')) ?></div>
    <?php endif; ?>

    <p>
        <?= Html::a('Criar utilizador', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return User::statusLabels()[$model->status];
                },
                'filter' => User::statusLabels(),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {restore}',
                'buttons' => [
                    //soft delete: so aparece nas contas que ainda nao estao apagadas
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fas fa-trash"></i>', Url::to(['delete', 'id' => $model->id]), [
                            'title' => 'Apagar (soft delete)',
                            'data-method' => 'post',
                            'data-confirm' => 'Apagar este utilizador? A conta fica desativada e pode ser reativada.',
                        ]);
                    },
                    //reativar: so aparece nas contas apagadas
                    'restore' => function ($url, $model) {
                        return Html::a('<i class="fas fa-undo"></i>', Url::to(['restore', 'id' => $model->id]), [
                            'title' => 'Reativar',
                            'data-method' => 'post',
                        ]);
                    },
                ],
                'visibleButtons' => [
                    'delete' => function ($model) {
                        return $model->status != User::STATUS_DELETED;
                    },
                    'restore' => function ($model) {
                        return $model->status == User::STATUS_DELETED;
                    },
                ],
            ],
        ],
    ]); ?>

</div>
