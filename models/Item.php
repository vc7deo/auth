<?php
namespace vc7deo\auth\models;

use yii\base\Model;


class Item extends Model
{
    public $name;
    public $description;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string', 'max' => 64],
            ['description', 'string'],

        ];
    }


}
