<?php

/**
 * This is the model class for table "tbl_received".
 *
 * The followings are the available columns in table 'tbl_received':
 * @property string $id
 * @property string $po_id
 * @property string $receive_date
 * @property string $transport_supplier
 * @property string $detail
 * @property string $po_no
 */
class Received extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_received';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('po_id, po_no', 'length', 'max'=>20),
			array('transport_supplier, detail', 'length', 'max'=>400),
			array('receive_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, po_id, receive_date, transport_supplier, detail, po_no', 'safe', 'on'=>'search'),
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
			'po_id'=>'PO ID',
			'po_no' => 'เลขที่คำสั่งซื้อ',
			'receive_date' => 'วันรับสินค้า',
			'transport_supplier' => 'ผู้จัดส่ง',
			'detail' => 'รายละเอียด',
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
		$criteria->compare('po_id',$this->po_id,true);
		$criteria->compare('receive_date',$this->receive_date,true);
		$criteria->compare('transport_supplier',$this->transport_supplier,true);
		$criteria->compare('detail',$this->detail,true);
		$criteria->compare('po_no',$this->po_no,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Received the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
