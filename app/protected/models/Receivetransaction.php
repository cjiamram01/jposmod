<?php

/**
 * This is the model class for table "tbl_receivetransaction".
 *
 * The followings are the available columns in table 'tbl_receivetransaction':
 * @property string $id
 * @property string $item_id
 * @property string $purchase_qty
 * @property string $receive_qty
 * @property integer $status
 * @property string $received_id
 * @property string $POdetail_id
 */
class Receivetransaction extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_receivetransaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_id', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('item_id, received_id, POdetail_id', 'length', 'max'=>20),
			array('purchase_qty, receive_qty', 'length', 'max'=>18),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, item_id, purchase_qty, receive_qty, status, received_id, POdetail_id', 'safe', 'on'=>'search'),
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
			'purchase_qty' => 'Purchase Qty',
			'receive_qty' => 'Receive Qty',
			'status' => 'Status',
			'received_id' => 'Received',
			'POdetail_id' => 'Podetail',
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
		$criteria->compare('purchase_qty',$this->purchase_qty,true);
		$criteria->compare('receive_qty',$this->receive_qty,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('received_id',$this->received_id,true);
		$criteria->compare('POdetail_id',$this->POdetail_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Receivetransaction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
