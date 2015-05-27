<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Tinyorder]].
 *
 * @see Tinyorder
 */
class TinyorderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Tinyorder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Tinyorder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}