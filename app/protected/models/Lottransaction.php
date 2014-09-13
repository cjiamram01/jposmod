<?php

/**
 * This is the model class for table "tbl_lottransaction".
 *
 * The followings are the available columns in table 'tbl_lottransaction':
 * @property string $id
 * @property string $item_id
 * @property integer $lot_no
 * @property string $create_date
 * @property string $quantity
 * @property string $barcode
 */
class Lottransaction extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_lottransaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lot_no', 'numerical', 'integerOnly'=>true),
			array('item_id', 'length', 'max'=>20),
			array('quantity', 'length', 'max'=>18),
			array('barcode', 'length', 'max'=>500),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, item_id, lot_no, create_date, quantity, barcode', 'safe', 'on'=>'search'),
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
			'item_id' => 'Item',
			'lot_no' => 'Lot No',
			'create_date' => 'Create Date',
			'quantity' => 'Quantity',
			'barcode' => 'Barcode',
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
		$criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('lot_no',$this->lot_no);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('barcode',$this->barcode,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Lottransaction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
