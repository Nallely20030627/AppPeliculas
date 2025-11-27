<?php

use app\models\Peliculas;
use yii\helpers\Html;
use yii\helpers\Url; // <-- Asegúrate de importar Url
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PeliculasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Peliculas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="peliculas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Peliculas'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_peliculas',
            'titulo',
            // 'sinipsis:ntext', // <-- Puedes descomentar esto si quieres ver la sinopsis
            'anio_lanzamiento',
            'duracion_min',
            'actores_id_actores',
            // 'generos_id_generos',
            
            // --- AQUÍ ESTÁ LA CORRECCIÓN ---
            [
                'attribute' => 'portada',
                'format' => 'html',
                'label' => 'Portada (Miniatura)', // <-- Opcional: cambiar la etiqueta
                'value' => function ($model) {
                    if ($model->portada && file_exists(Yii::getAlias('@webroot/portadas/' . $model->portada))) {
                        // Esta es la línea corregida:
                        return Html::img(Url::to('@web/portadas/' . $model->portada), ['width' => '75px']);
                    } else {
                        return 'N/A';
                    }
                },
            ],
            // --- FIN DE LA CORRECCIÓN ---

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Peliculas $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_peliculas' => $model->id_peliculas, 'actores_id_actores' => $model->actores_id_actores, 'generos_id_generos' => $model->generos_id_generos]);
                 }
            ],
        ],
    ]); ?>


</div>