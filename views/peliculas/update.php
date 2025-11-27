<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Peliculas $model */

$this->title = Yii::t('app', 'Update Peliculas: {name}', [
    'name' => $model->id_peliculas,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Peliculas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_peliculas, 'url' => ['view', 'id_peliculas' => $model->id_peliculas, 'actores_id_actores' => $model->actores_id_actores, 'generos_id_generos' => $model->generos_id_generos]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="peliculas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
