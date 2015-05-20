<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $user_id
 * @property string $name
 * @property string $is_student
 * @property string $college
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Worker extends ActiveRecord
{

}
