<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[OfflineOrder]].
 *
 * @see OfflineOrder
 */
class OfflineOrderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return OfflineOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OfflineOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}