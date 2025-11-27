<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Actores]].
 *
 * @see Actores
 */
class ActoresQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Actores[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Actores|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
