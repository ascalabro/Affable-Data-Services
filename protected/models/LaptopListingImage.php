<?php

/**
 * This is the model class for table "laptop_listing_image".
 *
 * The followings are the available columns in table 'laptop_listing_image':
 * @property integer $id
 * @property string $path
 * @property integer $laptop_listing_id
 *
 * The followings are the available model relations:
 * @property LaptopListing $laptopListing
 */
class LaptopListingImage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaptopListingImage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection()
	{
		return Yii::app()->dbAffable;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laptop_listing_image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('laptop_listing_id', 'numerical', 'integerOnly'=>true),
			array('path', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, path, laptop_listing_id', 'safe', 'on'=>'search'),
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
			'laptopListing' => array(self::BELONGS_TO, 'LaptopListing', 'laptop_listing_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'path' => 'Path',
			'laptop_listing_id' => 'Laptop Listing',
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
		$criteria->compare('path',$this->path,true);
		$criteria->compare('laptop_listing_id',$this->laptop_listing_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}