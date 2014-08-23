<?php

/**
 * This is the model class for table "tbl_purchaseorder".
 *
 * The followings are the available columns in table 'tbl_purchaseorder':
 * @property string $id
 * @property integer $supplier_id
 * @property string $po_no
 * @property string $order_date
 * @property integer $Status
 * @property string $Comment
 *
 * The followings are the available model relations:
 * @property TblSupplier $supplier
 */
class Purchaseorder extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_purchaseorder';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_id', 'required'),
			array('supplier_id, Status', 'numerical', 'integerOnly'=>true),
			array('po_no,quotation_no', 'length', 'max'=>20),
			array('Comment', 'length', 'max'=>500),
			array('order_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, supplier_id, po_no, order_date, Status, Comment, quotation_no', 'safe', 'on'=>'search'),
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
			'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'supplier_id' => yii::t('app','ผู้ให้บริการ'),
			'po_no' => yii::t('app','หมายเลขสั่งซื้อ'),
			'quotation_no' => yii::t('app','เลขที่ใบเสนอราคา'),
			'order_date' => yii::t('app','วันที่สั่งซื้อ'),
			'Status' => yii::t('app','Status'),
			'Comment' => yii::t('app','หมายเหตุ'),
		);
	}

   public function getSupplier($supplier_id)
  {
       $supplier = Yii::app()->db->createCommand()
      ->select('farmer_name,farmer_id')
      ->from('tbl_Purchaseorder po')
      ->join('tb_farmer sup', 'sup.farmer_id=po.supplier_id')
      ->where('id=:id', array(':id'=>$supplier_id))
      ->queryRow();

      $arr = array();
      $arr['farmer_id'] = $supplier['farmer_id'];
      $arr['farmer_name'] = $supplier['farmer_name'];
      return $arr;


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
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('po_no',$this->po_no,true);
		$criteria->compare('order_date',$this->order_date,true);
		$criteria->compare('Status',$this->Status);
		$criteria->compare('Comment',$this->Comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Purchaseorder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
