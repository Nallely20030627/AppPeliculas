<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "directores".
 *
 * @property int $id_directores
 * @property string $nombre
 * @property string|null $fecha_nacimiento
 *
 * @property DirectoresHasPeliculas[] $directoresHasPeliculas
 * @property Peliculas[] $peliculasIdPeliculas
 */
class Directores extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'directores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_nacimiento'], 'default', 'value' => null],
            [['nombre'], 'required'],
            [['fecha_nacimiento'], 'safe'],
            [['nombre'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_directores' => Yii::t('app', 'Id Directores'),
            'nombre' => Yii::t('app', 'Nombre'),
            'fecha_nacimiento' => Yii::t('app', 'Fecha Nacimiento'),
        ];
    }

    /**
     * Gets query for [[DirectoresHasPeliculas]].
     *
     * @return \yii\db\ActiveQuery|DirectoresHasPeliculasQuery
     */
    public function getDirectoresHasPeliculas()
    {
        return $this->hasMany(DirectoresHasPeliculas::class, ['directores_id_directores' => 'id_directores']);
    }

    /**
     * Gets query for [[PeliculasIdPeliculas]].
     *
     * @return \yii\db\ActiveQuery|PeliculasQuery
     */
    public function getPeliculasIdPeliculas()
    {
        return $this->hasMany(Peliculas::class, ['id_peliculas' => 'peliculas_id_peliculas', 'actores_id_actores' => 'peliculas_actores_id_actores'])->viaTable('directores_has_peliculas', ['directores_id_directores' => 'id_directores']);
    }

    /**
     * {@inheritdoc}
     * @return DirectoresQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DirectoresQuery(get_called_class());
    }

}
