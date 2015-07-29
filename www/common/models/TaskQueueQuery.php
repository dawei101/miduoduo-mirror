<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[TaskQueue]].
 *
 * @see TaskQueue
 */
class TaskQueueQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TaskQueue[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TaskQueue|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}