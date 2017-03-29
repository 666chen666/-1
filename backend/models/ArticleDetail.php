<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_detail".
 *
 * @property string $article_id
 * @property string $content
 */
class ArticleDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id'], 'required'],
            [['content'], 'string'],
            [['article_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'article_id' => '文章ID',
            'content' => '内容',
        ];
    }
}
