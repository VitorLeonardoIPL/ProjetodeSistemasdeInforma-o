<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

declare(strict_types=1);

namespace frontend\assets;

use common\assets\ColorModeAsset;
use yii\bootstrap5\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    //CSS carregados em todas as paginas (pela ordem da lista)
    public $css = [
        //fontes do template Cental (Lato e Montserrat), vindas do Google Fonts
        'https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap',
        //icones Font Awesome (ex: <i class="fas fa-car"></i>)
        'https://use.fontawesome.com/releases/v5.15.4/css/all.css',
        //icones Bootstrap Icons (ex: <i class="bi bi-house"></i>)
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css',
        //animacoes de entrada dos elementos (fadeIn, slide, ...)
        'lib/animate/animate.min.css',
        //estilo do carrossel de viaturas
        'lib/owlcarousel/assets/owl.carousel.min.css',
        //estilo principal do template Cental
        'css/style.css',
        //estilos nossos; fica em ultimo para poder alterar os do template
        'css/site.css',
    ];

//JS carregados no fim de todas as paginas
//(o jQuery e o Bootstrap JS ja vem do $depends, por isso nao estao aqui)
    public $js = [
        //faz os elementos aparecerem com animacao ao fazer scroll
        'lib/wow/wow.min.js',
        //efeitos de movimento suave (usado no botao "voltar ao topo")
        'lib/easing/easing.min.js',
        //deteta quando um elemento entra no ecra ao fazer scroll
        'lib/waypoints/waypoints.min.js',
        //carrossel de viaturas
        'lib/owlcarousel/owl.carousel.min.js',
        //script do template: liga o spinner, as animacoes, o carrossel e o "voltar ao topo"
        'js/main.js',
    ];
    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        ColorModeAsset::class,
    ];
}
