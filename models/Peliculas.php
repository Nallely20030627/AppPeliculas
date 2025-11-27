<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile; // <-- IMPORTAR CLASE

/**
 * This is the model class for table "peliculas".
 *
 * @property int $id_peliculas
 * @property string $titulo
 * @property string|null $sinipsis
 * @property string|null $anio_lanzamiento
 * @property int|null $duracion_min
 * @property int $actores_id_actores
 * @property int $generos_id_generos
 * @property string|null $portada  // <-- Esta columna ya la tienes en tu BD
 *
 * @property Actores $actoresIdActores
 * @property DirectoresHasPeliculas[] $directoresHasPeliculas
 * @property Generos $generosIdGeneros
 */
class Peliculas extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imagenFile; // <-- PROPIEDAD PARA EL ARCHIVO

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'peliculas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'actores_id_actores', 'generos_id_generos'], 'required'],
            [['sinipsis', 'portada'], 'string'],

            // --- VALIDACIÓN DE FECHA ---
            // Le decimos que esperamos el formato YYYY-MM-DD
            [['anio_lanzamiento'], 'date', 'format' => 'php:Y-m-d'],

            // --- VALIDACIÓN DE DURACIÓN ---
            // Aseguramos que sea un número entero y mayor a 0
            [['duracion_min'], 'integer', 'min' => 1],

            [['actores_id_actores', 'generos_id_generos'], 'integer'],
            [['titulo'], 'string', 'max' => 255],
            [['actores_id_actores'], 'exist', 'skipOnError' => true, 'targetClass' => Actores::class, 'targetAttribute' => ['actores_id_actores' => 'id_actores']],
            [['generos_id_generos'], 'exist', 'skipOnError' => true, 'targetClass' => Generos::class, 'targetAttribute' => ['generos_id_generos' => 'id_generos']],

            [['imagenFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 5], // 5MB Max
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_peliculas' => Yii::t('app', 'Id Peliculas'),
            'titulo' => Yii::t('app', 'Titulo'),
            'sinipsis' => Yii::t('app', 'Sinipsis'),
            'anio_lanzamiento' => Yii::t('app', 'Anio Lanzamiento'),
            'duracion_min' => Yii::t('app', 'Duracion Min'),
            'actores_id_actores' => Yii::t('app', 'Actores Id Actores'),
            'generos_id_generos' => Yii::t('app', 'Generos Id Generos'),
            'portada' => Yii::t('app', 'Portada'),
            'imagenFile' => Yii::t('app', 'Archivo de Portada'), // <-- ETIQUETA PARA EL CAMPO DE SUBIDA
        ];
    }

    /**
     * Sube el archivo de imagen.
     * @param string $oldFile El nombre del archivo anterior, si existe, para borrarlo.
     * @return boolean si la subida fue exitosa
     */
    public function upload($oldFile = null)
    {
        if ($this->imagenFile instanceof UploadedFile) {
            // Verificar que el archivo temporal existe
            if (!is_file($this->imagenFile->tempName)) {
                Yii::error("El archivo temporal no existe: " . $this->imagenFile->tempName, __METHOD__);
                $this->addError('imagenFile', 'El archivo subido no está disponible. Intenta nuevamente.');
                return false;
            }
            // Generar un nombre de archivo único
            $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '_', strtolower($this->titulo));
            $filename = $baseName . '_' . time() . '.' . $this->imagenFile->extension;
            $path = Yii::getAlias('@webroot/portadas/') . $filename;

            // Asegurarse que el directorio exista
            $dir = dirname($path);
            if (!is_dir($dir)) {
                @mkdir($dir, 0777, true);
            }

            // Guardar el archivo nuevo
            if ($this->imagenFile->saveAs($path)) {
                // Borrar el archivo anterior si existe
                if ($oldFile) {
                    $this->deletePortada($oldFile);
                }
                // Guardar el nuevo nombre de archivo en el modelo
                $this->portada = $filename;
                return true;
            } else {
                Yii::error("No se pudo guardar el archivo en: {$path}", __METHOD__);
                return false;
            }
        }
        return false; // No se subió ningún archivo nuevo
    }

    /**
     * Borra un archivo de portada físico.
     * @param string $filename Nombre del archivo a borrar.
     */
    public function deletePortada($filename = null)
    {
        $fileToDelete = $filename ?: $this->portada;
        if ($fileToDelete) {
            $path = Yii::getAlias('@webroot/portadas/') . $fileToDelete;
            if (is_file($path)) {
                @unlink($path); // @ para suprimir errores si no se puede borrar
            }
        }
    }

    /**
     * Sobrescribir afterDelete para borrar la imagen asociada.
     */
    public function afterDelete()
    {
        parent::afterDelete();
        $this->deletePortada();
    }


    // ... (El resto de tus métodos: getActoresIdActores, getDirectoresHasPeliculas, getGenerosIdGeneros, find) ...

    /**
     * Gets query for [[ActoresIdActores]].
     *
     * @return \yii\db\ActiveQuery|ActoresQuery
     */
    public function getActoresIdActores()
    {
        return $this->hasOne(Actores::class, ['id_actores' => 'actores_id_actores']);
    }

    /**
     * Gets query for [[DirectoresHasPeliculas]].
     *
     * @return \yii\db\ActiveQuery|DirectoresHasPeliculasQuery
     */
    public function getDirectoresHasPeliculas()
    {
        return $this->hasMany(DirectoresHasPeliculas::class, ['peliculas_id_peliculas' => 'id_peliculas', 'peliculas_actores_id_actores' => 'actores_id_actores', 'peliculas_generos_id_generos' => 'generos_id_generos']);
    }

    /**
     * Gets query for [[GenerosIdGeneros]].
     *
     * @return \yii\db\ActiveQuery|GenerosQuery
     */
    public function getGenerosIdGeneros()
    {
        return $this->hasOne(Generos::class, ['id_generos' => 'generos_id_generos']);
    }

    /**
     * {@inheritdoc}
     * @return PeliculasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PeliculasQuery(get_called_class());
    }
}