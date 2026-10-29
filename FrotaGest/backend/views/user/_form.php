<?php

use backend\models\UserForm;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\UserForm $model */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //autocomplete: impede o browser de preencher o username e a password com o login guardado ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['autocomplete' => 'new-password'])->hint('Ao editar, deixa vazio para manter a password atual.') ?>

    <?= $form->field($model, 'role')->dropDownList(UserForm::roleList(), ['prompt' => 'Escolher role...'])->hint('O role decide o que a pessoa pode fazer no sistema.') ?>

    <?= $form->field($model, 'status')->dropDownList(User::statusLabels()) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
