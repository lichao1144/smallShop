<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Goods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Goods', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'goods_id',
            'goods_name',
            'cate_id',
            'brand_id',
            'goods_sn',
            //'shop_price',
            //'market_price',
            //'goods_img',
            //'goods_thumb',
            //'content:ntext',
            //'goods_number',
            //'is_new',
            //'is_best',
            //'is_hot',
            //'is_on_sale',
            //'keywords',
            //'description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
