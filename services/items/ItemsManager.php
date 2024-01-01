<?php

namespace app\services\items;

use app\exception\ValidationException;
use app\models\Items;
use app\models\MultipleModel;
use RuntimeException;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

class ItemsManager
{
    private $newMultipleModelsItems = [];
    private $multipleModelsItems = [];
    private $data;
    private $purchaseID;

    public function __construct(array $data, $purchaseID, $multipleModelsItems = [])
    {
        $this->data = $data;
        $this->multipleModelsItems = $multipleModelsItems;
        $this->purchaseID = $purchaseID;

    }

    public function execute()
    {
        $this->loadData();
        $this->saveModel();

    }

    private function saveModel()
    {
        $oldIDs = ArrayHelper::map($this->multipleModelsItems, 'id', 'id');

        $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($this->newMultipleModelsItems, 'id', 'id')));

        if (!empty($deletedIDs)) {
            Items::deleteAll(['id' => $deletedIDs]);
        }
        foreach ($this->newMultipleModelsItems as $model) {
            if(!$model->save()) {
                throw new RuntimeException('Problem with save data in model Items');
            }
        }
    }

    public function loadData()
    {
        $this->newMultipleModelsItems = MultipleModel::createMultiple(Items::class, 'id', $this->multipleModelsItems);
        Model::loadMultiple($this->newMultipleModelsItems, $this->data);


        foreach ($this->newMultipleModelsItems as $model) {
            $model->purchase_id = $this->purchaseID;
        }
        if (!empty(ActiveForm::validateMultiple($this->newMultipleModelsItems))) {
            throw new ValidationException('Problem with validate data in model Items');
        }
    }
}
