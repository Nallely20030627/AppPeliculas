<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Directores]].
 *
 * @see Directores
 */
class DirectoresQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Directores[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Directores|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
