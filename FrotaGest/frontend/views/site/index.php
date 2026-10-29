<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Início';
//a pagina inicial nao mostra o banner (tem o carrossel)
$this->params['semBanner'] = true;
?>
<div class="site-index">

    <!-- Carousel Start (copiado do index.html do Cental e adaptado) -->
    <div class="header-carousel mb-5">
        <div id="carouselId" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-inner" role="listbox">

                <!-- slide 1 -->
                <div class="carousel-item active">
                    <!-- @web = URL da pasta frontend/web (onde copiamos a pasta img) -->
                    <?= Html::img('@web/img/carousel-2.jpg', ['class' => 'img-fluid w-100', 'alt' => 'Viatura da frota']) ?>
                    <div class="carousel-caption">
                        <div class="container py-4">
                            <div class="row g-5">

                                <!-- caixa azul a esquerda (no template era o formulario de reserva) -->
                                <div class="col-lg-6 fadeInLeft animated" data-animation="fadeInLeft" data-delay="1s" style="animation-delay: 1s;">
                                    <div class="bg-secondary rounded p-5 text-start">
                                        <h4 class="text-white mb-4">PRECISA DE UMA VIATURA?</h4>
                                        <p class="text-white mb-4">Consulte as viaturas disponíveis e faça a sua requisição. O coordenador recebe o pedido e responde rapidamente.</p>

                                        <?php if (Yii::$app->user->isGuest): ?>
                                            <!-- sem sessao: botoes para entrar ou registar -->
                                            <?= Html::a('Entrar', ['/site/login'], ['class' => 'btn btn-light w-100 py-2 mb-2']) ?>
                                            <?= Html::a('Criar conta', ['/site/signup'], ['class' => 'btn btn-outline-light w-100 py-2']) ?>
                                        <?php else: ?>
                                            <!-- com sessao: mensagem com o nome do utilizador -->
                                            <p class="text-white mb-0">Bem-vindo, <strong><?= Html::encode(Yii::$app->user->identity->username) ?></strong>!</p>
                                        <?php endif ?>
                                    </div>
                                </div>

                                <!-- texto grande a direita (so aparece em ecras grandes: d-none d-lg-flex) -->
                                <div class="col-lg-6 d-none d-lg-flex fadeInRight animated" data-animation="fadeInRight" data-delay="1s" style="animation-delay: 1s;">
                                    <div class="text-start">
                                        <h1 class="display-5 text-white">A frota da sua organização, sempre à mão</h1>
                                        <p>Requisições, viaturas e deslocações num só sítio</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Carousel End -->

</div>