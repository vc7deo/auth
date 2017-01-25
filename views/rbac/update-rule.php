<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\auth\models\AuthRule;

$this->title = 'Create Rule';
$this->params['breadcrumbs'][] = ['label' => 'Rules', 'url' => ['rule-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="content-form">
	<?php if(isset($flag)):
echo $flag;
	endif;?>
   <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
   <?= $form->field($model,'rule_name')->dropDownList(
                                ArrayHelper::map( AuthRule::find()->all(), 'name', 'name'),
                                [
                                    'prompt'=>'Select Rule',
                                ]); ?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Create' , ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
