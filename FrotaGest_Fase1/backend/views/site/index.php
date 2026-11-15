<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use common\models\condutor;
use common\models\manutencao;
use common\models\requisicao;
use common\models\viatura;
use hail812\adminlte\widgets\SmallBox;

$this->title = 'Dashboard';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="row">
<?php if (Yii::$app->user->can('gerirViaturas')): ?>
    <div class="col-lg-3 col-6">
        <?= SmallBox::widget([
            'title' => (string) viatura::find()->count(),
            'text' => 'Viaturas',
            'icon' => 'fas fa-car',
        ]) ?>
    </div>
<?php endif; ?>
<?php if (Yii::$app->user->can('gerirViaturas')): ?>
    <div class="col-lg-3 col-6">
        <?= SmallBox::widget([
            'title' => (string) viatura::find()->where(['estado' => 'disponivel'])->count(),
            'text' => 'Viaturas disponíveis',
            'icon' => 'fas fa-check',
            'theme' => 'success',
        ]) ?>
    </div>
<?php endif; ?>
<?php if (Yii::$app->user->can('verRequisicao')): ?>
    <div class="col-lg-3 col-6">
        <?= SmallBox::widget([
            'title' => (string) requisicao::find()->where(['estado' => 'pendente'])->count(),
            'text' => 'Requisições pendentes',
            'icon' => 'fas fa-clipboard-list',
            'theme' => 'warning',
        ]) ?>
    </div>
<?php endif; ?>
<?php if (Yii::$app->user->can('gerirCondutores')): ?>
    <div class="col-lg-3 col-6">
        <?= SmallBox::widget([
            'title' => (string) condutor::find()->count(),
            'text' => 'Condutores',
            'icon' => 'fas fa-id-card',
            'theme' => 'info',
        ]) ?>
    </div>
<?php endif; ?>
</div>
