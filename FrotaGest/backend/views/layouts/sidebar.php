<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use hail812\adminlte\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?= Url::home() ?>" class="brand-link">
        <i class="brand-image fas fa-truck-moving" style="margin-top: 2px; opacity: .8"></i>
        <span class="brand-text font-weight-light"><?= Html::encode(Yii::$app->name) ?></span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block"><?= Html::encode(Yii::$app->user->identity?->username) ?></a>
            </div>
        </div>

        <nav class="mt-2">
            <?= Menu::widget([
                'items' => [
                    ['label' => 'Dashboard', 'icon' => 'tachometer-alt', 'url' => ['/site/index']],
                    ['label' => 'Viaturas', 'icon' => 'car', 'url' => ['/viatura/index']],
                    //a mesma listagem de viaturas, ja filtrada pelo estado
                    ['label' => 'Viaturas disponíveis', 'icon' => 'check', 'url' => ['/viatura/index', 'ViaturaSearch[estado]' => 'disponivel']],
                    //a listagem de requisicoes ja filtrada pelo estado
                    ['label' => 'Requisições pendentes', 'icon' => 'clipboard-list', 'url' => ['/requisicao/index', 'RequisicaoSearch[estado]' => 'pendente']],
                    ['label' => 'Condutores', 'icon' => 'id-card', 'url' => ['/condutor/index']],
                    ['label' => 'Utilizadores', 'icon' => 'users', 'url' => ['/user/index']],
                ],
            ]) ?>
        </nav>
    </div>
</aside>
