<?php

use app\models\Actores;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\ActoresSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Actores');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="actores-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Actores'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_actores',
            'nombre',
            'fecha_nacimiento',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Actores $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_actores' => $model->id_actores]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
