<?php

/**
 * This is the model class for table "tbl_itemgroup".
 *
 * The followings are the available columns in table 'tbl_itemgroup':
 * @property string $group_code
 * @property string $DESCRIPTION
 * @property string $parent_code
 * @property integer $LEVEL
 * @property string $id
 */
class Itemgroup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_itemgroup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('LEVEL', 'numerical', 'integerOnly'=>true),
			array('group_code, parent_code', 'length', 'max'=>20),
			array('DESCRIPTION', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('group_code, DESCRIPTION, parent_code, LEVEL, id', 'safe', 'on'=>'search'),
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
			'group_code' => Yii::t('app','Group Code'),
			'DESCRIPTION' => Yii::t('app','Description'),
			'parent_code' => Yii::t('app','Parent Code'),
			'LEVEL' => Yii::t('app','Level'),
			'id' => Yii::t('app','ID'),
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

		$criteria->compare('group_code',$this->group_code,true);
		$criteria->compare('DESCRIPTION',$this->DESCRIPTION,true);
		$criteria->compare('parent_code',$this->parent_code,true);
		$criteria->compare('LEVEL',$this->LEVEL);
		$criteria->compare('id',$this->id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Itemgroup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
