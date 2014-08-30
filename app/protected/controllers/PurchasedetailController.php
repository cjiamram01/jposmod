<?php

class PurchasedetailController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	

	





	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		//$dataProvider=new CActiveDataProvider('Purchasedetail');
		$model=new Purchasedetail();
		$this->render('formPurchaseDetail',array(
			'model'=>$model,
		));
	}

	public function getPurchaseDetails($id)
	    {
	           $purchaseDetail=Yii::app()->db->createCommand()
	          ->select("pd.id,tp.product_name,pd.qty,pd.price,tp.product_code")
	          ->from('tbl_purchasedetail pd')
	          ->join('tb_product tp','pd.Item_id=tp.product_id')
	          ->where('pd.PurchaseOrder_id=:id',array(':id'=>$id))
	          ->queryRow(); 
	           return   $purchaseDetail;  
	    }
	

	


	public function actionGetProductJson()
	{
	
		$term=$_REQUEST['term'];
	    if(isset($term))
	    {
	         $request=trim($term);

	        $criteria=new CDbCriteria();
	        $criteria->select ="product_name,product_id";
	        $criteria->condition="product_name like :request";
	        $criteria->params=array(':request'=> '%'.$request.'%');
	        $criteria->limit=30;
	        $model=Product::model()->findAll($criteria);

	        $data=array();
	        foreach($model as $get)
	        {
	            $data[]=array('label' => $get->product_name,'id'=>$get->product_id);
	        }

	        $this->layout='empty';
	        echo json_encode($data);
	    }

	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Purchasedetail the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Purchasedetail::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Purchasedetail $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='purchasedetail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
