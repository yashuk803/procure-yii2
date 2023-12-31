<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "items".
 *
 * @property int $id
 * @property int $purchase_id
 * @property string $description
 * @property int $quantity
 * @property string $unit
 *
 * @property Purchases $purchase
 */
class Items extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['purchase_id', 'description', 'quantity', 'unit'], 'required'],
            [['purchase_id', 'quantity'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['unit'], 'string', 'max' => 50],
            [['purchase_id'], 'exist', 'skipOnError' => true, 'targetClass' => Purchases::class, 'targetAttribute' => ['purchase_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'purchase_id' => 'Purchase ID',
            'description' => 'Description',
            'quantity' => 'Quantity',
            'unit' => 'Unit',
        ];
    }

    /**
     * Gets query for [[Purchase]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPurchase()
    {
        return $this->hasOne(Purchases::class, ['id' => 'purchase_id']);
    }
}
