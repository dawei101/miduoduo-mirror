<?php

use yii\db\Schema;
use console\BaseMigration;
use common\models\District;

class m150806_091206_add_pinyin_and_short_name_to_city_table extends BaseMigration
{
    public function up()
    {
        $sqls = "
            alter table jz_district add short_name varchar(500);
            alter table jz_district add pinyin varchar(500);
            alter table jz_district add short_pinyin varchar(500);
            alter table jz_district add is_hot boolean not null default true;
            ";
        //$this->execSqls($sqls);

        $zsstr = "蒙古族、回族、藏族、维吾尔族、苗族、彝族、壮族、布依族、朝鲜族、满族、侗族、瑶族、白族、土家族、哈尼族、哈萨克族、傣族、黎族、僳僳族、佤族、畲族、高山族、拉祜族、水族、东乡族、纳西族、景颇族、柯尔克孜族、土族、达斡尔族、仫佬族、羌族、布朗族、撒拉族、毛南族、仡佬族、锡伯族、阿昌族、普米族、塔吉克族、怒族、乌孜别克族、俄罗斯族、鄂温克族、德昂族、保安族、裕固族、京族、塔塔尔族、独龙族、鄂伦春族、赫哲族、门巴族、珞巴族、基诺族、傈僳族";

        $rezs = '/(' . implode('|', explode('、', $zsstr)) . ')/u';
        foreach (District::find()->all() as $d){
            $name = $d->name;
            if (strlen($name)>6){
                $name = preg_replace('/(维吾尔自治区|自治旗|各族自治县|矿区|蒙古自治州|地区|左旗|前旗|后旗|左旗|中旗|县|縣|市|省|区|州|联合旗|特别行政)$/u', '', $name);
                $name = preg_replace('/(自治)$/u', '', $name);
                $name = preg_replace($rezs, '', $name);
            }
            $d->short_name = $name;
            if ('东乡族自治县'==$d->name || '鄂温克族自治旗' ==$d->name){
                $d->short_name = $d->name;
            }
            print $d->name . "\n";
            $r = file_get_contents('http://string2pinyin.sinaapp.com/?str='. $d->short_name .'&accent=0');
            $json = json_decode($r);
            if ($json){
                $d->pinyin = $json->pinyin;
                $d->short_pinyin = '';
                foreach (explode(' ', $json->pinyin) as $v){
                    $d->short_pinyin .= substr($v, 0, 1);
                }
            }

            print $name . "\t\t>>\t"  . $d->pinyin ." + " . $d->short_pinyin . " >> \t\t" . $d->name . "\n";
            $d->save();
        }
        return false;
    }

    public function down()
    {
        echo "m150806_091206_add_pinyin_and_short_name_to_city_table cannot be reverted.\n";

        return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
