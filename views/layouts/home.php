<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        body {
            background-color: #141414;
            color: #fff;
        }
        .navbar {
            background-color: #141414 !important; /* Match body background or keep it transparent/dark */
        }
        /* Override bootstrap defaults for dark theme if needed */
    </style>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header id="header">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                ['label' => 'Inicio', 'url' => ['/site/index']],
                (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin') ?
                [
                    'label' => 'Gestionar Peliculas',
                    'items' => [
                        ['label' => 'Actores', 'url' => ['/actores/index']],
                        ['label' => 'Peliculas', 'url' => ['/peliculas/index']],
                        ['label' => 'Generos', 'url' => ['/generos/index']],
                        ['label' => 'Directores', 'url' => ['/directores/index']],
                        ['label' => 'Usuarios', 'url' => ['/user/index']]
                    ],
                ] : '',
                Yii::$app->user->isGuest ? '' : ['label' => 'Cambiar password', 'url' => ['/user/change-password']],
                Yii::$app->user->isGuest
                ? ['label' => 'Iniciar sesion', 'url' => ['/site/login']]
                : '<li class="nav-item">'
                . Html::beginForm(['/site/logout'])
                . Html::submitButton(
                    'Cerrar sesion (' . Yii::$app->user->identity->apellido . ' ' . Yii::$app->user->identity->nombre . ') ' . Yii::$app->user->identity->role,
                    ['class' => 'nav-link btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ]
        ]);
        NavBar::end();
        ?>
    </header>

    <main id="main" class="flex-shrink-0" role="main">
        <!-- Removed .container class to allow full width -->
        <div>
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <div class="container mt-5 pt-4">
                    <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
                </div>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer id="footer" class="mt-auto py-3 bg-dark text-white-50">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
                <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
