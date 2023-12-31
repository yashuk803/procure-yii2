<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "purchases".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property float $budget
 * @property int $status_id
 * @property int $user_id
 *
 * @property Items[] $items
 * @property User $user
 */
class Purchases extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchases';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'budget', 'status_id', 'user_id'], 'required'],
            [['description'], 'string'],
            [['budget'], 'number'],
            [['status_id', 'user_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'budget' => 'Budget',
            'status_id' => 'Status ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Items]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Items::class, ['purchase_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
