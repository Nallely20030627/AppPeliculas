<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url; // <-- IMPORTAR URL

/** @var yii\web\View $this */
/** @var app\models\Peliculas $model */

$this->title = $model->titulo; // <-- Usar título en lugar de ID
if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin') {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Peliculas'), 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="peliculas-view container mt-5">
    <div class="row">
        <div class="col-md-4">
            <?php if ($model->portada): ?>
                <?= Html::img(Url::to('@web/portadas/' . $model->portada), ['class' => 'img-fluid rounded shadow-lg', 'alt' => $model->titulo]) ?>
            <?php else: ?>
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded" style="height: 400px;">
                    <span>No Image</span>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-8">
            <h1 class="display-4 fw-bold text-white"><?= Html::encode($this->title) ?></h1>
            <div class="mb-3">
                <span class="badge bg-primary me-2"><?= $model->anio_lanzamiento ?></span>
                <span class="badge bg-secondary"><?= $model->duracion_min ?> min</span>
            </div>
            <p class="lead text-white-50"><?= Html::encode($model->sinipsis) ?></p>
            <div class="mt-4 text-white">
                <p><strong>Género:</strong> <?= $model->generosIdGeneros ? $model->generosIdGeneros->nombre : 'N/A' ?></p>
                <p><strong>Actor Principal:</strong> <?= $model->actoresIdActores ? $model->actoresIdActores->nombre : 'N/A' ?></p>
            </div>
            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin'): ?>
            <div class="mt-5">
                <?= Html::a(Yii::t('app', 'Editar'), ['update', 'id_peliculas' => $model->id_peliculas], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id_peliculas' => $model->id_peliculas], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>