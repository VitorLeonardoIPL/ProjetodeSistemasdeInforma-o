<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\requisicao $model */

$this->title = 'Criar requisição';
$this->params['breadcrumbs'][] = ['label' => 'Requisições', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requisicao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
