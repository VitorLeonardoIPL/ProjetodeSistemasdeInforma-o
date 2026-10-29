<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\condutor $model */

$this->title = 'Criar condutor';
$this->params['breadcrumbs'][] = ['label' => 'Condutores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="condutor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
