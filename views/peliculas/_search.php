<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PeliculasSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="peliculas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id_peliculas') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'sinipsis') ?>

    <?= $form->field($model, 'anio_lanzamiento') ?>

    <?= $form->field($model, 'duracion_min') ?>

    <?php // echo $form->field($model, 'portada') ?>

    <?php // echo $form->field($model, 'actores_id_actores') ?>

    <?php // echo $form->field($model, 'generos_id_generos') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
