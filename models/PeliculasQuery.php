<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Peliculas]].
 *
 * @see Peliculas
 */
class PeliculasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Peliculas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Peliculas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
