<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "data".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string|null $key
 * @property string|null $type
 * @property string|null $value
 * @property int $request_id
 *
 * @property Data[] $datas
 * @property Data $parent
 * @property Request $request
 */
class Data extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'request_id'], 'integer'],
            [['value'], 'string'],
            [['request_id'], 'required'],
            [['key', 'type'], 'string', 'max' => 255],
            [['request_id'], 'exist', 'skipOnError' => true, 'targetClass' => Request::class, 'targetAttribute' => ['request_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Data::class, 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'key' => 'Key',
            'type' => 'Type',
            'value' => 'Value',
            'request_id' => 'Request ID',
        ];
    }

    /**
     * Gets query for [[Datas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDatas()
    {
        return $this->hasMany(Data::class, ['parent_id' => 'id']);
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Data::class, ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[Request]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::class, ['id' => 'request_id']);
    }
}
