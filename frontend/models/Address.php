<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $name
 * @property integer $member_id
 * @property string $provience
 * @property string $city
 * @property string $area
 * @property integer $tel
 * @property string $site
 * @property integer $flag
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'province', 'city', 'area', 'tel', 'site'], 'required'],
            [['member_id', 'tel', 'flag'], 'integer'],
            [['name', 'province', 'city', 'area', 'site'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '* 收 货 人',
            'member_id' => '用户ID',
            'province' => '省份',
            'city' => '省份',
            'area' => '省份',
            'tel' => '* 联系电话',
            'site' => '* 详细地址',
            'flag' => '默认地址',
        ];
    }
}
