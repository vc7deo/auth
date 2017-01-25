<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Rules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-index">
<h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Create Rule', ['create-rule'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'type',
                'value' => 'typeLabel',
            ],

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view-rule}{update-rule}{delete-rule}{rule-permission}',
            'buttons' => [
                'view-rule' => function ($url) {
                    return Html::a('&nbsp;<span class="glyphicon glyphicon-eye-open"></span>', $url,['title' => 'View']);
                }, 
                'update-rule' => function ($url) {
                    return Html::a('&nbsp;<span class="glyphicon glyphicon-pencil"></span>', $url,['title' => 'Update']);
                }, 
                'delete-rule' => function ($url) {
                    return Html::a('&nbsp;<span class="glyphicon glyphicon-trash"></span>', $url,['title' => 'Delete','data' => [
                    'confirm' => 'Are you absolutely sure ?',
                ]]);
                }, 
                'rule-permission' => function ($url) {
                    return Html::a('&nbsp;<span class="glyphicon glyphicon-check"></span>', $url,['title' => 'Assign Permission']);
                },       
            ],
            ],
        ],
    ]); ?>
