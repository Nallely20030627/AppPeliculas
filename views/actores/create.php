<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Actores $model */

$this->title = Yii::t('app', 'Create Actores');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Actores'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="actores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
