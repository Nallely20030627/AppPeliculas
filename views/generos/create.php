<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Generos $model */

$this->title = Yii::t('app', 'Create Generos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Generos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="generos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
