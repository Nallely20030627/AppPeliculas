<?php

use app\models\Directores;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\DirectoresSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Directores');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="directores-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Directores'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_directores',
            'nombre',
            'fecha_nacimiento',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Directores $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_directores' => $model->id_directores]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
