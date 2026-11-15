<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="error-page">
    <div class="error-content" style="margin-left: auto;">
        <h3><i class="fas fa-exclamation-triangle text-danger"></i> <?= Html::encode($name) ?></h3>

        <p><?= nl2br(Html::encode($message)) ?></p>

        <p>
            O erro acima ocorreu enquanto o servidor processava o pedido.
            Entretanto, pode <?= Html::a('voltar ao dashboard', Yii::$app->homeUrl) ?>.
        </p>
    </div>
</div>
