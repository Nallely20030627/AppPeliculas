<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actores".
 *
 * @property int $id_actores
 * @property string $nombre
 * @property string|null $fecha_nacimiento
 *
 * @property Peliculas[] $peliculas
 */
class Actores extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actores';
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
            'id_actores' => Yii::t('app', 'Id Actores'),
            'nombre' => Yii::t('app', 'Nombre'),
            'fecha_nacimiento' => Yii::t('app', 'Fecha Nacimiento'),
        ];
    }

    /**
     * Gets query for [[Peliculas]].
     *
     * @return \yii\db\ActiveQuery|PeliculasQuery
     */
    public function getPeliculas()
    {
        return $this->hasMany(Peliculas::class, ['actores_id_actores' => 'id_actores']);
    }

    /**
     * {@inheritdoc}
     * @return ActoresQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActoresQuery(get_called_class());
    }

}
