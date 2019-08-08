<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tp_goods".
 *
 * @property string $goods_id
 * @property string $goods_name
 * @property int $cate_id
 * @property int $brand_id
 * @property string $goods_sn
 * @property string $shop_price
 * @property string $market_price
 * @property string $goods_img
 * @property string $goods_thumb
 * @property string $content
 * @property int $goods_number
 * @property int $is_new 新品 1是 0否
 * @property int $is_best 精品 1是 0否
 * @property int $is_hot 热销品 1是 0否
 * @property int $is_on_sale 是否上下
 * @property string $keywords
 * @property string $description
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tp_goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['goods_name', 'cate_id', 'brand_id', 'goods_sn', 'shop_price', 'market_price'], 'required'],
            [['cate_id', 'brand_id', 'goods_number', 'is_new', 'is_best', 'is_hot', 'is_on_sale'], 'integer'],
            [['shop_price', 'market_price'], 'number'],
            [['content'], 'string'],
            [['goods_name', 'goods_img', 'goods_thumb', 'keywords'], 'string', 'max' => 120],
            [['goods_sn'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'goods_id' => '商品ID',
            'goods_name' => '商品名称',
            'cate_id' => 'Cate ID',
            'brand_id' => 'Brand ID',
            'goods_sn' => 'Goods Sn',
            'shop_price' => 'Shop Price',
            'market_price' => 'Market Price',
            'goods_img' => 'Goods Img',
            'goods_thumb' => 'Goods Thumb',
            'content' => 'Content',
            'goods_number' => 'Goods Number',
            'is_new' => 'Is New',
            'is_best' => 'Is Best',
            'is_hot' => 'Is Hot',
            'is_on_sale' => 'Is On Sale',
            'keywords' => 'Keywords',
            'description' => 'Description',
        ];
    }
}
