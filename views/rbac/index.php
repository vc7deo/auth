<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="content-index">
    <p>
        <?= Html::a('Create Role', ['create-role'], ['class' => 'btn btn-success']) ?>
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
            'template' => '{view-role}{update-role}{delete-role}{role-permission}',
            'buttons' => [
                'view-role' => function ($url) {
                    return Html::a('&nbsp;<span class="glyphicon glyphicon-eye-open"></span>', $url,['title' => 'View']);
                }, 
                'update-role' => function ($url) {
                    return Html::a('&nbsp;<span class="glyphicon glyphicon-pencil"></span>', $url,['title' => 'Update']);
                }, 
                'delete-role' => function ($url) {
                    return Html::a('&nbsp;<span class="glyphicon glyphicon-trash"></span>', $url,['title' => 'Delete','data' => [
                    'confirm' => 'Are you absolutely sure ?',
                   // 'method' => 'post',
                ]]);
                }, 
                'role-permission' => function ($url) {
                    return Html::a('&nbsp;<span class="glyphicon glyphicon-check"></span>', $url,['title' => 'Assign Permission']);
                },       
            ],
            ],
        ],
    ]); ?>
</div>