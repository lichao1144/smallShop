<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Goods;

/**
 * GoodsSearch represents the model behind the search form of `frontend\models\Goods`.
 */
class GoodsSearch extends Goods
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['goods_id', 'cate_id', 'brand_id', 'goods_number', 'is_new', 'is_best', 'is_hot', 'is_on_sale'], 'integer'],
            [['goods_name', 'goods_sn', 'goods_img', 'goods_thumb', 'content', 'keywords', 'description'], 'safe'],
            [['shop_price', 'market_price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Goods::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'goods_id' => $this->goods_id,
            'cate_id' => $this->cate_id,
            'brand_id' => $this->brand_id,
            'shop_price' => $this->shop_price,
            'market_price' => $this->market_price,
            'goods_number' => $this->goods_number,
            'is_new' => $this->is_new,
            'is_best' => $this->is_best,
            'is_hot' => $this->is_hot,
            'is_on_sale' => $this->is_on_sale,
        ]);

        $query->andFilterWhere(['like', 'goods_name', $this->goods_name])
            ->andFilterWhere(['like', 'goods_sn', $this->goods_sn])
            ->andFilterWhere(['like', 'goods_img', $this->goods_img])
            ->andFilterWhere(['like', 'goods_thumb', $this->goods_thumb])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
