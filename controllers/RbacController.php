<?php

namespace vc7deo\auth\controllers;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use vc7deo\auth\models\AuthItem;
use vc7deo\auth\models\AuthItemChild;
use vc7deo\auth\models\User;
use vc7deo\auth\models\AuthAssignment;
use yii\widgets\ActiveForm;

class RbacController extends Controller
{
    public function actionAssignment($id)
    {
        $model = new AuthAssignment();
        $permissions = AuthItem::find()->where(['type' => 2])->all();
        $roles = AuthItem::find()->where(['type' => 1])->all();
        $selected = AuthAssignment::find()->joinWith(['itemName b'], true, 'INNER JOIN')->where(['user_id' => $id])->orderBy('b.type')->all();
        $user = User::findOne($id);
        $auth = Yii::$app->authManager;
        if ($model->load(Yii::$app->request->post())) {

            if(!empty($model->aar)):
            foreach($model->aar as $r):
            $role = $auth->createRole($r);
            $auth->assign($role, $id);
            endforeach;
            endif;

            if(!empty($model->aap)):
            foreach($model->aap as $p):
            $permission = $auth->createPermission($p);
            $auth->assign($permission, $id);
            endforeach;
            endif;

            return $this->redirect(['assignment', 'id' => $id]);
        } else {
            return $this->render('assignment', [
                'model' => $model,
                'permissions' => $permissions,
                'roles' => $roles,
                'selected' => $selected,
                'user' => $user,
            ]);
        }
    }

    public function actionCreateRole()
    {

        $model = new AuthItem();
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ActiveForm::validate($model);
      }
        if ($model->load(Yii::$app->request->post())) {
        $auth = Yii::$app->authManager;
        $createRole = $auth->createRole($model->name);
        $createRole->description = $model->description;    
        $auth->add($createRole);
        return $this->redirect(['view-role','id'=>$createRole->name]);
        } else {
            return $this->render('create-role', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateRule()
    {
        $model = new AuthItem();
        $model->scenario = 'create-rule';
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
        $auth = Yii::$app->authManager;
        $createPermission = $auth->createPermission($model->name);
        $createPermission->ruleName = $model->rule_name;    
        $createPermission->description = $model->description;    
        $auth->add($createPermission);
        return $this->redirect(['view-rule','id'=>$createPermission->name]);  
        } else {
            return $this->render('create-rule', [
                'model' => $model,
            ]);
        }
    }

    public function actionIndex()
    {
        $query = AuthItem::find()->where(['type' => 1]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRuleIndex()
    {
        $query = AuthItem::find()->where(['type' => 2]);
        $query->innerJoinWith(['ruleName']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('rule-index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionRolePermission($id)
    {

        $model = new AuthItemChild();
        $permissions = AuthItem::find()->where(['!=','name',$id])->andWhere(['type' => 2])->all();
        $roles = AuthItem::find()->where(['!=','name',$id])->andWhere(['type' => 1])->all();        
        $selected = AuthItemChild::find()->joinWith(['child0 c'], true, 'INNER JOIN')->where(['parent' => $id])->orderBy('c.type')->all();
        $auth = Yii::$app->authManager;
        
        if ($model->load(Yii::$app->request->post())) {

            if(!empty($model->aar)):
            foreach($model->aar as $r):
            $parent = $auth->createRole($id);
            $child = $auth->createRole($r);
            $auth->addChild($parent, $child);
            endforeach;
            endif;

            if(!empty($model->aap)):
            foreach($model->aap as $p):
            $parent = $auth->createRole($id);
            $child = $auth->createPermission($p);
            $auth->addChild($parent, $child);
            endforeach;
            endif;

            return $this->redirect(['role-permission', 'id' => $id]);
        } else {
            return $this->render('permission', [
                'model' => $model,
                'permissions' => $permissions,
                'roles' => $roles,
                'selected' => $selected,
                'id' => $id,
            ]);
        }
    }
public function actionRulePermission($id)
    {
        $model = new AuthItemChild();
        $permissions = AuthItem::find()->where(['!=','name',$id])->andWhere(['type' => 2])->all();
        $selected = AuthItemChild::find()->joinWith(['child0 c'], true, 'INNER JOIN')->where(['parent' => $id])->orderBy('c.type')->all();
        $auth = Yii::$app->authManager;
        
        if ($model->load(Yii::$app->request->post())) {

            if(!empty($model->aap)):
            foreach($model->aap as $p):
            $parent = $auth->createRole($id);
            $child = $auth->createPermission($p);
            $auth->addChild($parent, $child);
            endforeach;
            endif;

            return $this->redirect(['rule-permission', 'id' => $id]);
        } else {
            return $this->render('rule-permission', [
                'model' => $model,
                'permissions' => $permissions,
                'selected' => $selected,
                'id' => $id,
            ]);
        }
    }
    public function actionUpdateRole($id)
    {
        $model = $this->findAuthItemModel($id);
        $role = $model->name;
        if ($model->load(Yii::$app->request->post())) {
        $auth = Yii::$app->authManager;
        $createRole = $auth->createRole($model->name);
        $createRole->description = $model->description;
        // $updateRole = $auth->getRole($role);
        // $updateRole->name = $model->name;
        // $updateRole->description = $model->description;
        $auth->update($role,$createRole);
            return $this->redirect(['view-role','id'=>$createRole->name]);
        } else {
            return $this->render('update-role', [
                'model' => $model,
            ]);
        }
    }
    public function actionDeleteRole($id)
    {
        $model = $this->findAuthItemModel($id);
        $auth = Yii::$app->authManager;
        $createRole = $auth->createRole($model->name);
        $auth->remove($createRole);
        return $this->redirect(['index']);
    }
    public function actionDeleteRule($id)
    {
        $model = $this->findAuthItemModel($id);
        $auth = Yii::$app->authManager;
        $createRole = $auth->createPermission($model->name);
        $auth->remove($createRole);
        return $this->redirect(['rule-index']);
    }
    public function actionUpdateRule($id)
    {
        $model = $this->findAuthItemModel($id);
        $model->scenario = 'create-rule';
        $role = $model->name;
        if ($model->load(Yii::$app->request->post())) {
        $auth = Yii::$app->authManager;
        $createPermission = $auth->createPermission($model->name);
        $createPermission->ruleName = $model->rule_name; 
        $createPermission->description = $model->description;
        $auth->update($role,$createPermission);
            return $this->redirect(['view-rule','id'=>$createPermission->name]);
        } else {
            return $this->render('update-rule', [
                'model' => $model,
            ]);
        }
    }

    public function actionUser()
    {
        $query = User::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('user', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewRole($id)
    {
        return $this->render('view-role', [
            'model' => $this->findAuthItemModel($id),
        ]);
    }

    public function actionViewRule($id)
    {
        return $this->render('view-rule', [
            'model' => $this->findAuthItemModel($id),
        ]);
    }
   public function actionRevokeAssignment()
    {
        $id = Yii::$app->request->getBodyParam('user_id');
        $item_name = Yii::$app->request->getBodyParam('item_name');
        $type = Yii::$app->request->getBodyParam('type');
        $auth = Yii::$app->authManager;
        $role = ($type == 1) ? $auth->createRole($item_name) : $auth->createPermission($item_name);
        $auth->revoke($role, $id);
        return $this->redirect(['assignment', 'id' => $id]);
    }

   public function actionRemovePermission()
    {
        $p = Yii::$app->request->getBodyParam('parent');
        $c = Yii::$app->request->getBodyParam('child');
        $type = Yii::$app->request->getBodyParam('type');
        $auth = Yii::$app->authManager;
        $parent = $auth->createRole($p);
        $child = ($type == 1) ? $auth->createRole($c) : $auth->createPermission($c);
        $auth->removeChild($parent, $child);
        return $this->redirect(['role-permission', 'id' => $p]);
    }

   public function actionRemoveRulePermission()
    {
        $p = Yii::$app->request->getBodyParam('parent');
        $c = Yii::$app->request->getBodyParam('child');
        $type = Yii::$app->request->getBodyParam('type');
        $auth = Yii::$app->authManager;
        $parent = $auth->createRole($p);
        $child = ($type == 1) ? $auth->createRole($c) : $auth->createPermission($c);
        $auth->removeChild($parent, $child);
        return $this->redirect(['rule-permission', 'id' => $p]);
    }

    protected function findAuthItemModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
