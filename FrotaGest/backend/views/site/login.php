<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var \common\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Iniciar sessão';
?>
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Inicie sessão para continuar</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>

        <?= $form->field($model, 'username', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3'],
        ])
            ->label(false)
            ->textInput(['placeholder' => 'Utilizador', 'autofocus' => true]) ?>

        <?= $form->field($model, 'password', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3'],
        ])
            ->label(false)
            ->passwordInput(['placeholder' => 'Palavra-passe']) ?>

        <div class="row">
            <div class="col-7">
                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => '<div class="icheck-primary">{input}{label}</div>',
                    'labelOptions' => ['class' => ''],
                    'uncheck' => null,
                ])->label('Lembrar-me') ?>
            </div>
            <div class="col-5">
                <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end() ?>
    </div>
</div>
