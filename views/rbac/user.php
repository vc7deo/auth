<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-index">
<h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email',

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view-user}{assignment}',
            'buttons' => [
                'view-user' => function ($url) {
                    return Html::a('&nbsp;<span class="glyphicon glyphicon-eye-open"></span>', $url,['title' => 'View']);
                }, 
                'assignment' => function ($url) {
                    return Html::a('&nbsp;<span class="glyphicon glyphicon-check"></span>', $url,['title' => 'Assign Role/Permission']);
                },        
            ],
            ],
        ],
    ]); ?>
