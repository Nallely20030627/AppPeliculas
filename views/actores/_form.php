<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Actores $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="actores-form card">
    <div class="card-body">
        <h3 class="card-title mb-4"><?= $model->isNewRecord ? 'Crear Nuevo Actor' : 'Actualizar Actor' ?></h3>

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
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <?= $form->field($model, 'nombre')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Ingrese el nombre del actor',
                        'class' => 'form-control form-control-lg'
                    ]) ?>
                </div>

                <div class="form-group mb-4">
                    <?= $form->field($model, 'fecha_nacimiento')->textInput([
                        'type' => 'date',
                        'class' => 'form-control form-control-lg'
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="form-group text-center mt-4">
            <?= Html::submitButton($model->isNewRecord ? 'Crear Actor' : 'Actualizar Actor', [
                'class' => $model->isNewRecord ? 'btn btn-primary btn-lg px-5' : 'btn btn-success btn-lg px-5',
            ]) ?>
            <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary btn-lg px-5 ms-3']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$this->registerCss("
    .actores-form {
        max-width: 800px;
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
    .ui-datepicker {
        background: white;
        padding: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,.1);
        border: none;
    }
    .ui-datepicker-header {
        background: #3498db;
        color: white;
        border: none;
    }
    .ui-datepicker-calendar thead th {
        color: #34495e;
    }
    .ui-datepicker-calendar td {
        padding: 2px;
    }
    .ui-datepicker-calendar .ui-state-default {
        background: #f8f9fa;
        border: none;
        text-align: center;
        padding: 5px;
    }
    .ui-datepicker-calendar .ui-state-hover {
        background: #3498db;
        color: white;
    }
");
?>
