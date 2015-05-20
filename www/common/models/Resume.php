<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * resume model
 *
 * @property integer $id
 * @property string $user_id
 * @property string $name
 * @property string $phonenum
 * @property smallint $gender
 * @property string $birthdate
 * @property string // 居住地
 * @property string // 工作地
 * @property smallint $degree
 * @property string $nation //民族 
 * @property string $height // 身高

 * @property string $is_student
 * @property string $college
 * @property string $avatar;
 * @property string $gov_id;

 * @property smallint $worker_type;
 * @property smallint $avaiable_time;

 * @property integer $status
 * @property datetime $created_time
 * @property datetime $updated_time
 * 
 * @property smallint $grade;
 */
class Resume extends ActiveRecord
{
    public static function tableName()
    {
        return 'jz_resumes';
    }

    public function rules()
    {
        return [
            [['id', 'user_id', 'gender', 'degree', 'grade', 'height', 'status'], 'integer'],
            [['name', 'phonenum', 'nation', 'college', 'avatar', 'gov_id'], 'string'],
            [['gender'], 'in', 'range'=>[0, 1, 2]],
            [['grade'], 'in', 'range'=>[1, 2, 3, 4, 5]],
            ['phonenum', 'match', 'pattern'=>'/^1[345789]\d{9}$/',
                'message'=>'手机号不正确，目前仅支持中国大陆手机号.']
        ];
    }
}
