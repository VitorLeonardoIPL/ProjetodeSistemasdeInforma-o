<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\condutor $model */

$this->title = 'Editar condutor: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Condutores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="condutor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
