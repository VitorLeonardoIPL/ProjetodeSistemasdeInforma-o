<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;

$this->render('_head');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?php $this->head() ?>
    <title><?= Html::encode($this->title ? $this->title . ' - ' . Yii::$app->name : Yii::$app->name) ?></title>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
<!-- Spinner Start: rodinha de carregamento; o main.js esconde-a quando a pagina acaba de carregar -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">A carregar...</span>
    </div>
</div>
<!-- Spinner End -->

<?= $this->render('_header') ?>

<main id="main" role="main">

    <?php //a pagina inicial desliga o banner com: $this->params['semBanner'] = true; ?>
    <?php if (empty($this->params['semBanner'])): ?>
        <!-- Header Start: banner escuro com o titulo e os breadcrumbs (copiado do about.html do Cental) -->
        <div class="container-fluid bg-breadcrumb mb-5">
            <div class="container text-center py-5" style="max-width: 900px;">
                <h4 class="text-white display-4 mb-4"><?= Html::encode($this->title) ?></h4>
                <?= Breadcrumbs::widget([
                    //primeiro link dos breadcrumbs (em vez de "Home")
                        'homeLink' => ['label' => 'Início', 'url' => Yii::$app->homeUrl],
                    //os restantes vem da view; se a view nao definir, usa o titulo
                        'links' => $this->params['breadcrumbs'] ?? [$this->title],
                    //classes do Cental: centrado e sem margem em baixo
                        'options' => ['class' => 'breadcrumb d-flex justify-content-center mb-0'],
                    //o ultimo item (pagina atual) fica a vermelho, como no template
                        'activeItemTemplate' => "<li class=\"breadcrumb-item active text-primary\">{link}</li>\n",
                ]) ?>
            </div>
        </div>
        <!-- Header End -->
    <?php endif ?>

    <div class="container">
        <!-- mensagens de sucesso/erro (ex: "Obrigado pelo seu contacto") -->
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<?= $this->render('_footer') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
