<?php

/**
 * This is the model class for table "listing".
 *
 * The followings are the available columns in table 'listing':
 * @property integer $id
 * @property string $default_img
 * @property string $brand_name
 * @property string $title
 * @property string $description
 * @property string $price
 * @property string $discount
 * @property string $last_change_date
 * @property integer $hit_count
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property ListingImage[] $listingImages
 */
class Listing extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Listing the static model class
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
		return 'listing';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('default_img, brand_name', 'required'),
			array('hit_count, status', 'numerical', 'integerOnly'=>true),
			array('default_img, brand_name', 'length', 'max'=>100),
			array('title', 'length', 'max'=>128),
			array('price', 'length', 'max'=>6),
			array('discount', 'length', 'max'=>4),
			array('description, last_change_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, default_img, brand_name, title, description, price, discount, last_change_date, hit_count, status', 'safe', 'on'=>'search'),
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
			'listingImages' => array(self::HAS_MANY, 'ListingImage', 'listing_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'default_img' => 'Default Img',
			'brand_name' => 'Brand Name',
			'title' => 'Title',
			'description' => 'Description',
			'price' => 'Price',
			'discount' => 'Discount',
			'last_change_date' => 'Last Change Date',
			'hit_count' => 'Hit Count',
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
		$criteria->compare('default_img',$this->default_img,true);
		$criteria->compare('brand_name',$this->brand_name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('discount',$this->discount,true);
		$criteria->compare('last_change_date',$this->last_change_date,true);
		$criteria->compare('hit_count',$this->hit_count);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}