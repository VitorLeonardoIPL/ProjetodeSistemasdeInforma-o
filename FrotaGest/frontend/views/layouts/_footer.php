<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\helpers\Html;


?>
<!-- Footer Start (copiado do index.html do Cental e adaptado ao Yii) -->
<div class="container-fluid footer py-5 mt-5">
    <div class="container py-5">
        <div class="row g-5">

            <!-- coluna 1: sobre a aplicacao -->
            <div class="col-md-6 col-lg-6">
                <div class="footer-item d-flex flex-column">
                    <h4 class="text-white mb-4"><?= Html::encode(Yii::$app->name) ?></h4>
                    <p class="mb-3">Plataforma de gestão da frota de viaturas: consulte as viaturas disponíveis, faça requisições e acompanhe o seu estado.</p>
                </div>
            </div>

            <!-- coluna 2: links rapidos (as mesmas rotas do menu) -->
            <div class="col-md-6 col-lg-6">
                <div class="footer-item d-flex flex-column">
                    <h4 class="text-white mb-4">Links Rápidos</h4>
                    <?= Html::a('<i class="fas fa-angle-right me-2"></i> Início', ['/site/index']) ?>
                    <?= Html::a('<i class="fas fa-angle-right me-2"></i> Sobre', ['/site/about']) ?>
                    <?= Html::a('<i class="fas fa-angle-right me-2"></i> Contacto', ['/site/contact']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Copyright Start -->
<div class="container-fluid copyright py-4">
    <div class="container">
        <div class="row g-4 align-items-center">
            <!-- nome da aplicacao + ano atual (date('Y') muda sozinho todos os anos) -->
            <div class="col-md-6 text-center text-md-start mb-md-0">
                <span class="text-body"><i class="fas fa-copyright text-light me-2"></i><?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?>, todos os direitos reservados.</span>
            </div>
            <!-- credito obrigatorio pela licenca do template (CC BY 4.0): NAO REMOVER -->
            <div class="col-md-6 text-center text-md-end text-body">
                Designed By <a class="border-bottom text-white" href="https://htmlcodex.com">HTML Codex</a>
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->

<!-- botao "voltar ao topo": aparece ao fazer scroll (o main.js trata do resto) -->
<a href="#" class="btn btn-secondary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>