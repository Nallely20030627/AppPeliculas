<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Actores $model */

$this->title = Yii::t('app', 'Update Actores: {name}', [
    'name' => $model->id_actores,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Actores'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_actores, 'url' => ['view', 'id_actores' => $model->id_actores]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="actores-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
