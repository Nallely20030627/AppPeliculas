<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Actores;
use app\models\Generos;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Peliculas $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="peliculas-form card">
    <div class="card-body">
        <h3 class="card-title mb-4"><?= $model->isNewRecord ? 'Crear Nueva Película' : 'Actualizar Película' ?></h3>

        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'form-horizontal',
                'enctype' => 'multipart/form-data'
            ],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
                'labelOptions' => ['class' => 'form-label'],
                'inputOptions' => ['class' => 'form-control'],
                'errorOptions' => ['class' => 'invalid-feedback'],
            ],
        ]); ?>

        <div class="row">
            <div class="col-md-8">
                <div class="form-group mb-4">
                    <?= $form->field($model, 'titulo')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Ingrese el título de la película',
                        'class' => 'form-control form-control-lg'
                    ]) ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <?= $form->field($model, 'anio_lanzamiento')->textInput([
                                'type' => 'date',
                                'class' => 'form-control form-control-lg date-input',
                                'placeholder' => 'YYYY-MM-DD',
                                'pattern' => '\d{4}-\d{2}-\d{2}'
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <?= $form->field($model, 'duracion_min')->textInput([
                                'type' => 'number',
                                'placeholder' => 'Duración en minutos',
                                'class' => 'form-control form-control-lg',
                                'min' => '1'
                            ]) ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <?= $form->field($model, 'generos_id_generos')->dropDownList(
                                ArrayHelper::map(Generos::find()->all(), 'id_generos', 'nombre'),
                                [
                                    'prompt' => 'Seleccione un género',
                                    'class' => 'form-control form-control-lg'
                                ]
                            ) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <?= $form->field($model, 'actores_id_actores')->dropDownList(
                                ArrayHelper::map(Actores::find()->all(), 'id_actores', 'nombre'),
                                [
                                    'prompt' => 'Seleccione un actor',
                                    'class' => 'form-control form-control-lg'
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <?= $form->field($model, 'sinipsis')->textarea([
                        'rows' => 6,
                        'placeholder' => 'Escriba la sinopsis de la película',
                        'class' => 'form-control form-control-lg'
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="portada-container mb-4">
                    <?php
                    if (!$model->isNewRecord && $model->portada && file_exists(Yii::getAlias('@webroot/portadas/' . $model->portada))) {
                        echo '<div class="current-image mb-3">';
                        echo '<label class="form-label">Portada actual:</label>';
                        echo Html::img(Url::to('@web/portadas/' . $model->portada), ['class' => 'img-fluid rounded']);
                        echo '</div>';
                    }
                    ?>

                    <?= $form->field($model, 'imagenFile')->fileInput([
                        'class' => 'form-control form-control-lg',
                        'accept' => 'image/*'
                    ])->hint('Formatos permitidos: jpg, png, gif') ?>
                </div>
            </div>
        </div>

        <div class="form-group text-center mt-4">
            <?= Html::submitButton($model->isNewRecord ? 'Crear Película' : 'Actualizar Película', [
                'class' => $model->isNewRecord ? 'btn btn-primary btn-lg px-5' : 'btn btn-success btn-lg px-5',
            ]) ?>
            <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary btn-lg px-5 ms-3']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$this->registerJs("
    $(document).ready(function() {
        // Formatear la fecha si ya existe
        var dateInput = $('.date-input');
        var currentDate = dateInput.val();
        
        if (currentDate) {
            var formattedDate = new Date(currentDate);
            if (!isNaN(formattedDate)) {
                dateInput.val(formattedDate.toISOString().split('T')[0]);
            }
        }

        // Validar la fecha al enviar el formulario
        $('.peliculas-form form').on('beforeSubmit', function(e) {
            var dateInput = $('.date-input');
            var dateValue = dateInput.val();
            
            if (dateValue) {
                var date = new Date(dateValue);
                if (isNaN(date)) {
                    alert('Por favor, ingrese una fecha válida en formato YYYY-MM-DD');
                    return false;
                }
            }
            return true;
        });

        // Añadir validación de fecha mientras se escribe
        dateInput.on('change', function() {
            var date = new Date($(this).val());
            if (isNaN(date)) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
    });
");

$this->registerCss("
    .peliculas-form {
        max-width: 1200px;
        margin: 2rem auto;
        box-shadow: 0 0 20px rgba(0,0,0,.1);
    }
    .card-title {
        color: #2c3e50;
        font-weight: 600;
        text-align: center;
    }
    .form-label {
        font-weight: 500;
        color: #34495e;
        margin-bottom: 0.5rem;
    }
    .form-control {
        border: 2px solid #eee;
        padding: 0.8rem;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52,152,219,.25);
    }
    .invalid-feedback {
        font-size: 0.85rem;
        color: #e74c3c;
    }
    .portada-container {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 10px;
    }
    .current-image img {
        width: 100%;
        height: auto;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0,0,0,.1);
    }
    .hint-block {
        font-size: 0.85rem;
        color: #7f8c8d;
        margin-top: 0.5rem;
    }
    .btn {
        transition: all 0.3s ease;
    }
    .btn-primary {
        background: linear-gradient(to right, #3498db, #2980b9);
        border: none;
    }
    .btn-success {
        background: linear-gradient(to right, #2ecc71, #27ae60);
        border: none;
    }
    .btn-secondary {
        background: linear-gradient(to right, #95a5a6, #7f8c8d);
        border: none;
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,.2);
    }
    textarea.form-control {
        min-height: 150px;
    }
    
    /* Estilos para el input de fecha */
    input[type='date'].form-control {
        position: relative;
        padding: 0.8rem;
    }
    
    input[type='date'].form-control::-webkit-calendar-picker-indicator {
        position: absolute;
        right: 10px;
        cursor: pointer;
        background-color: transparent;
        padding: 5px;
        border-radius: 3px;
        transition: all 0.3s ease;
    }
    
    input[type='date'].form-control::-webkit-calendar-picker-indicator:hover {
        background-color: rgba(0,0,0,0.1);
    }
    
    input[type='date'].form-control.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220,53,69,.25);
    }
");
?>