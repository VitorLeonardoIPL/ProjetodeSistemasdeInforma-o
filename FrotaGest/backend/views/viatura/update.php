<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\viatura $model */

$this->title = 'Editar viatura: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Viaturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="viatura-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
