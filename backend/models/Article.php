<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $sort
 * @property integer $status
 * @property integer $article_category_id
 * @property integer $inputtime
 */
class Article extends \yii\db\ActiveRecord
{
    public $content;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'status', 'article_category_id'], 'required'],
            [['intro','content'], 'string'],
            [['sort', 'status', 'article_category_id', 'inputtime'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章名',
            'intro' => '简介',
            'sort' => '排序',
            'status' => '状态',
            'content'=>'内容',
            'article_category_id' => '是否为帮助信息',
            'inputtime' => '添加时间',
        ];
    }

    public function getCate(){
        return $this->hasOne(ArticleCategory::className(),['id'=>'article_category_id']);
    }
}
