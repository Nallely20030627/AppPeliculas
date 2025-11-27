<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "generos".
 *
 * @property int $id_generos
 * @property string $nombre
 *
 * @property Peliculas[] $peliculas
 */
class Generos extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'generos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 100],
            [['nombre'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_generos' => Yii::t('app', 'Id Generos'),
            'nombre' => Yii::t('app', 'Nombre'),
        ];
    }

    /**
     * Gets query for [[Peliculas]].
     *
     * @return \yii\db\ActiveQuery|PeliculasQuery
     */
    public function getPeliculas()
    {
        return $this->hasMany(Peliculas::class, ['generos_id_generos' => 'id_generos']);
    }

    /**
     * {@inheritdoc}
     * @return GenerosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GenerosQuery(get_called_class());
    }

}
