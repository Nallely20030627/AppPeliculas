<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "directores_has_peliculas".
 *
 * @property int $directores_id_directores
 * @property int $peliculas_id_peliculas
 * @property int $peliculas_actores_id_actores
 *
 * @property Directores $directoresIdDirectores
 * @property Peliculas $peliculasIdPeliculas
 */
class DirectoresHasPeliculas extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'directores_has_peliculas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['directores_id_directores', 'peliculas_id_peliculas', 'peliculas_actores_id_actores'], 'required'],
            [['directores_id_directores', 'peliculas_id_peliculas', 'peliculas_actores_id_actores'], 'integer'],
            [['directores_id_directores', 'peliculas_id_peliculas', 'peliculas_actores_id_actores'], 'unique', 'targetAttribute' => ['directores_id_directores', 'peliculas_id_peliculas', 'peliculas_actores_id_actores']],
            [['directores_id_directores'], 'exist', 'skipOnError' => true, 'targetClass' => Directores::class, 'targetAttribute' => ['directores_id_directores' => 'id_directores']],
            [['peliculas_id_peliculas', 'peliculas_actores_id_actores'], 'exist', 'skipOnError' => true, 'targetClass' => Peliculas::class, 'targetAttribute' => ['peliculas_id_peliculas' => 'id_peliculas', 'peliculas_actores_id_actores' => 'actores_id_actores']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'directores_id_directores' => Yii::t('app', 'Directores Id Directores'),
            'peliculas_id_peliculas' => Yii::t('app', 'Peliculas Id Peliculas'),
            'peliculas_actores_id_actores' => Yii::t('app', 'Peliculas Actores Id Actores'),
        ];
    }

    /**
     * Gets query for [[DirectoresIdDirectores]].
     *
     * @return \yii\db\ActiveQuery|DirectoresQuery
     */
    public function getDirectoresIdDirectores()
    {
        return $this->hasOne(Directores::class, ['id_directores' => 'directores_id_directores']);
    }

    /**
     * Gets query for [[PeliculasIdPeliculas]].
     *
     * @return \yii\db\ActiveQuery|PeliculasQuery
     */
    public function getPeliculasIdPeliculas()
    {
        return $this->hasOne(Peliculas::class, ['id_peliculas' => 'peliculas_id_peliculas', 'actores_id_actores' => 'peliculas_actores_id_actores']);
    }

    /**
     * {@inheritdoc}
     * @return DirectoresHasPeliculasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DirectoresHasPeliculasQuery(get_called_class());
    }

}
