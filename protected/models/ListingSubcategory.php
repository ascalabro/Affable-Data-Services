<?php

/**
 * This is the model class for table "listing_subcategory".
 *
 * The followings are the available columns in table 'listing_subcategory':
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $parent_category_id
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property ListingCategory $parentCategory
 * @property Listing[] $listings
 */
class ListingSubcategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ListingSubcategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'listing_subcategory';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, parent_category_id', 'required'),
			array('parent_category_id, status', 'numerical', 'integerOnly'=>true),
			array('name, slug', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, slug, parent_category_id, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'parentCategory' => array(self::BELONGS_TO, 'ListingCategory', 'parent_category_id'),
			'listings' => array(self::MANY_MANY, 'Listing', 'm2m_listing_subcategory(subcategory_id, listing_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'slug' => 'Slug',
			'parent_category_id' => 'Parent Category',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('parent_category_id',$this->parent_category_id);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}