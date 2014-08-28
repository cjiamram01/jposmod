<?php

/**
 * This is the model class for table "tbl_shiping".
 *
 * The followings are the available columns in table 'tbl_shiping':
 * @property string $id
 * @property string $customer
 * @property string $shiping_date
 * @property string $detail
 * @property string $user_id
 * @property integer $status
 * @property string $car_code
 * @property string $picture
 */
class Shiping extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_shiping';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status', 'numerical', 'integerOnly'=>true),
			array('customer', 'length', 'max'=>400),
			array('detail, picture', 'length', 'max'=>500),
			array('user_id, car_code', 'length', 'max'=>20),
			array('shiping_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer, shiping_date, detail, user_id, status, car_code, picture', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'customer' => 'ลูกค้า',
			'shiping_date' => 'วันส่งของ',
			'detail' => 'รายละเอียด',
			'user_id' => 'User',
			'status' => 'สถานะ',
			'car_code' => 'ทะเบียนรถ',
			'picture' => 'รูปภาพ',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('customer',$this->customer,true);
		$criteria->compare('shiping_date',$this->shiping_date,true);
		$criteria->compare('detail',$this->detail,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('car_code',$this->car_code,true);
		$criteria->compare('picture',$this->picture,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Shiping the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
