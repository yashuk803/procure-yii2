<?php

namespace app\services\purchases;

use app\exception\ValidationException;
use app\models\Purchases;
use app\services\items\ItemsManager;
use RuntimeException;

class PurchaseManager
{
    private $data;
    private $modelPurchases;
    public function  __construct($data, Purchases $modelPurchases)
    {
        $this->data = $data;
        $this->modelPurchases = $modelPurchases;
    }

    public function execute()
    {
        try {
            $transaction = \Yii::$app->db->beginTransaction();

            $this->loadData();
            $this->saveData();

            $itemManager = new ItemsManager(
                $this->data,
                $this->modelPurchases->id,
                $this->modelPurchases->items
            );

            $itemManager->execute();

            $transaction->commit();

            return $this->modelPurchases->id;

        } catch (\Exception $e) {
            $transaction->rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    private function saveData()
    {

        if(!$this->modelPurchases->save()) {
            throw new RuntimeException('Problem with save data in model Purchases');
        }
    }

    private function loadData()
    {

        if($this->modelPurchases->isNewRecord) {
            $this->modelPurchases->user_id = \Yii::$app->user->identity->getId();
        }

        if(!$this->modelPurchases->load($this->data)) {
            throw new RuntimeException('Problem with load data in model Purchases');
        }

        if(!$this->modelPurchases->validate()) {
                throw new ValidationException('Validation Purchases');
        }

    }
}
