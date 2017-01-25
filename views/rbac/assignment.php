<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$permissionList = ArrayHelper::map($permissions, 'name', 'name');
$roleList = ArrayHelper::map($roles, 'name', 'name');
$dbList = ArrayHelper::map($selected, 'item_name', 'item_name');
$actualPList = array_diff($permissionList, $dbList);
$actualRList = array_diff($roleList, $dbList);

$this->title = 'User :- '.$user->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['user']];
$this->params['breadcrumbs'][] = $this->title;
 ?>
  <h1><?= Html::encode($this->title) ?></h1>
<div class="row">
        <div class="col-xs-6">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Remove Roles/Permission From <?=$user->username?></h3>
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
 <tr><td>   <?=$items->item_name?>
 </td><td>   <?=($items->itemName->type == 1) ? "Role" : "Permission";?>
 </td><td>                         <?= Html::a(
                                    'Remove',
                                    ['rbac/revoke-assignment'],
                                    [    'data'=>[
        'method' => 'post',
        'confirm' => 'Are you sure?',
        'params'=>[ 'item_name' => $items->item_name,'user_id' => $user->id,'type' => $items->itemName->type],
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
              <h3 class="box-title">Add Roles/Permission To <?=$user->username?></h3>
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
<th>Roles</th>
<th>Type</th>
</tr>
</thead>
<tbody>
<?=$form->field($model, 'aar')
           ->checkboxList( 
                    $actualRList, 
                      [
                         'item'=>function ($index, $label, $name, $checked, $value){
                            return '<tr><td>
                                    <input name="AuthAssignment[aar][]" type="checkbox" value="'.$value.'" />
                                    </td><td>'.$label.'</td>
                                    <td>Role</td></tr>';
                                    }
                      ])->label(false);
                            
                           
?>
      </tbody>
              </table>
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
                                    <input name="AuthAssignment[aap][]" type="checkbox" value="'.$value.'" />
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


