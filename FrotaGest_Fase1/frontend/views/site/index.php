<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Início';
//a pagina inicial nao mostra o banner (tem o carrossel)
$this->params['semBanner'] = true;
?>
<div class="site-index">

    <!-- Carousel Start (estrutura do Cental, textos do mockup da especificacao - Figura 2) -->
    <div class="header-carousel mb-5">
        <div id="carouselId" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-inner" role="listbox">

                <div class="carousel-item active">
                    <!-- @web = URL da pasta frontend/web (onde copiamos a pasta img) -->
                    <?= Html::img('@web/img/carousel-2.jpg', ['class' => 'img-fluid w-100', 'alt' => 'Viatura da frota']) ?>
                    <div class="carousel-caption">
                        <div class="container py-4">
                            <div class="row g-5">

                                <!-- caixa azul a esquerda: apresentacao e botoes -->
                                <div class="col-lg-6 fadeInLeft animated" data-animation="fadeInLeft" data-delay="1s" style="animation-delay: 1s;">
                                    <div class="bg-secondary rounded p-5 text-start">
                                        <h4 class="text-primary mb-3">GESTÃO DE FROTA INTERNA</h4>
                                        <p class="text-white mb-4">Requisite uma viatura em quatro passos, acompanhe a aprovação em tempo real e registe quilómetros e combustível sem papel, na web ou no telemóvel.</p>

                                        <?php if (Yii::$app->user->isGuest): ?>
                                            <!-- sem sessao: so ha login (as contas sao criadas pelo administrador no back-office) -->
                                            <?= Html::a('Iniciar sessão', ['/site/login'], ['class' => 'btn btn-light w-100 py-2']) ?>
                                        <?php else: ?>
                                            <!-- com sessao: boas-vindas (o botao "Requisitar viatura" entra quando houver o catalogo) -->
                                            <p class="text-white mb-0">Bem-vindo, <strong><?= Html::encode(Yii::$app->user->identity->username) ?></strong>!</p>
                                        <?php endif ?>
                                    </div>
                                </div>

                                <!-- titulo grande a direita (so em ecras grandes: d-none d-lg-flex) -->
                                <div class="col-lg-6 d-none d-lg-flex fadeInRight animated" data-animation="fadeInRight" data-delay="1s" style="animation-delay: 1s;">
                                    <div class="text-start">
                                        <h1 class="display-5 text-white">A viatura da empresa, a um pedido de distância.</h1>
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