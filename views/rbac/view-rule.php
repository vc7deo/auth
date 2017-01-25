<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model backend\models\Banner */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Rules', 'url' => ['rule-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="banner-view">
    <p>
        <?= Html::a('Update', ['update-rule', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete-rule', 'id' => $model->name], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'rule_name',
            'description:html',
            'created_at:date',
            'updated_at:date',
        ],
    ]) ?>

</div>
