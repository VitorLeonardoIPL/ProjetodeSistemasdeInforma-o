<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\bootstrap5\Nav;
use yii\helpers\Html;

//links do menu principal
//o widget Nav transforma cada item num <a class="nav-link"> e marca o da pagina atual como "active"
$items = [
        ['label' => 'Início','url' => ['/site/index'],
        ],
        ['label' => 'Sobre','url' => ['/site/about'],
        ],
        ['label' => 'Contacto','url' => ['/site/contact'],
        ],
];

?>
<!-- Navbar Start (copiado do index.html do Cental e adaptado ao Yii) -->
<div class="container-fluid nav-bar sticky-top px-0 px-lg-4 py-2 py-lg-0">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">

            <!-- logotipo: icone de carro + nome da aplicacao; leva a pagina inicial -->
            <a href="<?= Yii::$app->homeUrl ?>" class="navbar-brand p-0">
                <h1 class="display-6 text-primary"><i class="fas fa-car-alt me-3"></i><?= Html::encode(Yii::$app->name) ?></h1>
            </a>

            <!-- botao "hamburguer" que aparece em ecras pequenos -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">

                <!-- links do menu, ao centro (mx-auto) -->
                <?= Nav::widget(['options' => ['class' => 'navbar-nav mx-auto py-0'],'items' => $items,
                ]) ?>

                <!-- botoes a direita: dependem de haver ou nao sessao iniciada -->
                <?php if (Yii::$app->user->isGuest): ?>
                    <?= Html::a('Registar', ['/site/signup'], ['class' => 'btn btn-light rounded-pill py-2 px-4 me-2']) ?>
                    <?= Html::a('Entrar', ['/site/login'], ['class' => 'btn btn-primary rounded-pill py-2 px-4']) ?>
                <?php else: ?>
                    <!-- nome do utilizador com sessao iniciada -->
                    <span class="me-3"><i class="fas fa-user text-primary me-2"></i><?= Html::encode(Yii::$app->user->identity->username) ?></span>
                    <!-- o logout tem de ser um POST (o SiteController so o aceita assim), por isso e um formulario -->
                    <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'd-inline']) ?>
                    <?= Html::submitButton('Sair', ['class' => 'btn btn-primary rounded-pill py-2 px-4']) ?>
                    <?= Html::endForm() ?>
                <?php endif ?>

            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->