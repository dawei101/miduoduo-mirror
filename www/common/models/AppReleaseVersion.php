<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%app_release_version}}".
 *
 * @property integer $id
 * @property integer $device_type
 * @property string $app_version
 * @property string $html_version
 * @property string $update_url
 * @property string $release_time
 * @property string $h5_map_file
 */
class AppReleaseVersion extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%app_release_version}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['device_type', 'app_version', 'html_version'], 'required'],
            [['device_type'], 'integer'],
            [['release_time'], 'safe'],
            [['app_version', 'html_version'], 'string', 'max' => 45],
            [['update_url'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'device_type' => '设备类型',
            'app_version' => '应用版本',
            'html_version' => 'html版本',
            'update_url' => '升级链接',
            'release_time' => '发布时间',
        ];
    }

    /**
     * @inheritdoc
     * @return AppReleaseVersionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppReleaseVersionQuery(get_called_class());
    }

    public function getFileMaps()
    {
        Utils::getH5VersionFile($this->html_version);
    }
}
