<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * freetime model
 *
 * @property integer $id
 * @property string $user_id
 * @property smallint $dayofweek
 * @property bool $morning
 * @property bool $afternoon
 * $property bool $evening
 */
class Freetime extends ActiveRecord
{
    public static function tableName()
    {
        return 'jz_freetimes';
    }

    public function rules()
    {
        return [
            [['user_id', 'dayofweek'], 'integer'],
            [['morning', 'afternoon', 'evening'], 'boolean'],
            [['dayofweek'], 'in', 'range'=>[1, 2, 3, 4, 5, 6, 7]],
        ];
    }
}
