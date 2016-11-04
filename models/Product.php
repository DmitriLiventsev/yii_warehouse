<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $picture
 * @property string $description
 * @property integer $private
 *
 * @property Category[] $categories
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_ids'], 'each', 'rule' => ['integer']],
            [['price'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 256],
            [['picture'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => \voskobovich\behaviors\ManyToManyBehavior::className(),
                'relations' => [
                    'category_ids' => 'categories',
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'picture' => 'Picture',
            'description' => 'Description',
            'price' => 'Price',
            'categories' => 'Categories',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('{{%product_category}}', ['product_id' => 'id']);
    }

    /**
     * @param string $keyField
     * @param string $valueField
     * @param bool $asArray
     * @return array
     */
    public static function listAll($keyField = 'id', $valueField = 'name', $asArray = true)
    {
        $query = static::find();
        if ($asArray) {
            $query->select([$keyField, $valueField])->asArray();
        }

        return ArrayHelper::map($query->all(), $keyField, $valueField);
    }

    /**
     * @return null|string
     */
    public function getImageUrl()
    {
        return $this->picture? '/Uploads/' . $this->picture : null;
    }
}
