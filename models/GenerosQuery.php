<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Generos]].
 *
 * @see Generos
 */
class GenerosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Generos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Generos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
