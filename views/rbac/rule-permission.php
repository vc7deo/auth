<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$permissionList = ArrayHelper::map($permissions, 'name', 'name');
$dbList = ArrayHelper::map($selected, 'child', 'child');
$actualPList = array_diff($permissionList, $dbList);

$this->title = 'Rule :- '.$id;
$this->params['breadcrumbs'][] = ['label' => 'Rules', 'url' => ['rule-index']];
$this->params['breadcrumbs'][] = $this->title;
 ?>
 <h1><?= Html::encode($this->title) ?></h1>
 <div class="row">
        <div class="col-xs-6">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Remove Permission From the Rule <?=$id?></h3>
            </div>
            <div class="box-body">
              <div class="row margin">
                <div class="col-sm-12">

<div class="meta-form">
<table class="table table-bordered table-striped">
<thead>
<tr>
<th>Role/Permissions</th>
<th>Type</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php foreach ($selected as $items):?>
 <tr><td>   <?=$items->child?>
 </td><td>   <?=($items->child0->type == 1) ? "Role" : "Permission";?>
 </td><td>                         <?= Html::a(
                                    'Remove',
                                    ['rbac/remove-rule-permission'],
                                    [    'data'=>[
        'method' => 'post',
        'confirm' => 'Are you sure?',
        'params'=>[ 'child' => $items->child,'parent' => $id,'type' => $items->child0->type],
    ]]
                                ) ?>
</td></tr>
<?php
endforeach;
?>
</tbody>
              </table>
</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xs-6">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Add Permission To the Rule <?=$id?></h3>
            </div>
            <div class="box-body">
              <div class="row margin">
                <div class="col-sm-12">

<div class="meta-form">
    <?php $form = ActiveForm::begin(); ?>
<table class="table table-bordered table-striped">
<thead>
<tr>
<th>#</th>
<th>Permissions</th>
<th>Type</th>
</tr>
</thead>
<tbody>
<?=$form->field($model, 'aap')
           ->checkboxList( 
                    $actualPList, 
                      [
                         'item'=>function ($index, $label, $name, $checked, $value){
                            return '<tr><td>
                                    <input name="AuthItemChild[aap][]" type="checkbox" value="'.$value.'" />
                                    </td><td>'.$label.'<td>Permission</td></tr>';
                                    }
                      ])->label(false);
                            
                           
?>
      </tbody>
              </table>
    <div class="form-group">
        <?= Html::submitButton('Add', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


