<?php

namespace app\controllers;

use app\models\Peliculas;
use app\models\PeliculasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use Yii;

/**
 * PeliculasController implements the CRUD actions for Peliculas model.
 */
class PeliculasController extends Controller
{
    public $layout = 'home'; // <-- Usar el layout oscuro

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => \yii\filters\AccessControl::class,
                    'only' => ['index', 'view', 'create', 'update', 'delete'],
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['view'],
                            'roles' => ['?', '@'], // Permite a invitados (?) y autenticados (@)
                        ],
                        [
                            'allow' => true,
                            'actions' => ['index', 'create', 'update', 'delete'],
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                                return !Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin';
                            }
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Peliculas models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PeliculasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Peliculas model.
     * @param int $id_peliculas Id Peliculas
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_peliculas)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_peliculas),
        ]);
    }

    /**
     * Creates a new Peliculas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Peliculas();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                
                // --- CAPTURAR LA IMAGEN ---
                $model->imagenFile = UploadedFile::getInstance($model, 'imagenFile');
                
                // Intentar subir la imagen si existe
                if ($model->imagenFile) {
                    if (!$model->upload()) {
                        // Hubo un error al subir
                        Yii::$app->session->setFlash('error', 'Error al subir la imagen.');
                        $model->addError('imagenFile', 'Error al procesar el archivo.');
                        // No guardamos el modelo si la subida falla
                        return $this->render('create', ['model' => $model]);
                    }
                    // 'portada' ya fue asignado en el método upload()
                }

                // Guardar el modelo (con o sin portada)
                if ($model->save(false)) { // Usamos save(false) para saltar validación (ya se hizo en load y upload)
                                        // O mejor, quita el 'false' si quieres que re-valide todo
                // if ($model->save()) { // <--- MEJOR ASÍ
                    Yii::$app->session->setFlash('success', 'Película creada exitosamente.');
                    return $this->redirect(['view', 'id_peliculas' => $model->id_peliculas]);
                } else {
                     Yii::$app->session->setFlash('error', 'No se pudo guardar la película. Revise los errores.');
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Peliculas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_peliculas Id Peliculas
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_peliculas)
    {
        $model = $this->findModel($id_peliculas);
        
        // Guardar el nombre de la portada vieja
        $oldPortada = $model->portada;

        if ($this->request->isPost && $model->load($this->request->post())) {
            
            // --- CAPTURAR LA NUEVA IMAGEN ---
            $model->imagenFile = UploadedFile::getInstance($model, 'imagenFile');
            
            $fileUploaded = false;
            if ($model->imagenFile) {
                // Si se subió un archivo nuevo, intentar subirlo
                if ($model->upload($oldPortada)) { // Pasamos la portada vieja para que la borre
                    $fileUploaded = true;
                } else {
                    // Hubo un error al subir
                    Yii::$app->session->setFlash('error', 'Error al subir la nueva imagen.');
                    $model->addError('imagenFile', 'Error al procesar el archivo.');
                    return $this->render('update', ['model' => $model]);
                }
            }

            // Si no se subió un archivo nuevo, mantenemos la portada anterior
            if (!$fileUploaded && !$model->imagenFile) {
                $model->portada = $oldPortada;
            }

            // Guardar el modelo
            if ($model->save()) { // save() validará los demás campos
                Yii::$app->session->setFlash('success', 'Película actualizada exitosamente.');
                return $this->redirect(['view', 'id_peliculas' => $model->id_peliculas]);
            } else {
                 Yii::$app->session->setFlash('error', 'No se pudo actualizar la película. Revise los errores.');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Peliculas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_peliculas Id Peliculas
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_peliculas)
    {
        // El método afterDelete en el modelo se encargará de borrar el archivo
        $this->findModel($id_peliculas)->delete();
        Yii::$app->session->setFlash('success', 'Película eliminada exitosamente.');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Peliculas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_peliculas Id Peliculas
     * @return Peliculas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_peliculas)
    {
        if (($model = Peliculas::findOne(['id_peliculas' => $id_peliculas])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}