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
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	/*public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}*/

	



	public function actionAjax()
	{
  

    if(isset($_GET['term']))
    {
         //$request=trim($_GET['term']);
         //echo $request."xxx";
         $request="G";
        $model=Product::model()->findAll(array("condition"=>"product_name like '$request%'"));
        $data=array();
        foreach($model as $get)
        {
            $data[]=$get->product_name;
        }
        $this->layout='empty';
        echo json_encode($data);
    }
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


	public function actionChooseItem()
	{
		$model=new Purchasedetail();
		if(isset($_POST['Purchasedetail']))
		{
			$product_id=$_POST['product_id'];
			$model->item_id=$product_id;
			$id= Yii::app()->request->getParam('id');
			$model->PurchaseOrder_id=$id;
			if($model->save())
			{
				
				//$modelQuery=new Purchasedetail();
				//$criteria = new CDbCriteria();
				//$criteria->condition="PurchaseOrder_id=:PurchaseOrder_id";
				//$criteria->params=array(":PurchaseOrder_id"=>$id);
				//$modelQuery=$model->findAll($criteria);
				$this->redirect(array('//basic/PO','id'=>$id));

			}
		}

		$id= Yii::app()->request->getParam('id');
		if(!isset($id))
		{
			$this->render('formPurchaseDetail',array(
				'modelDetail'=>$model,'model'=>$model
			));
		}
		else
		{
				$modelDetail=new Purchasedetail();
				$criteria=new CDbCriteria();
				$criteria->condition="PurchaseOrder_id=:PurchaseOrder_id";
				$criteria->params=array(":PurchaseOrder_id"=>$id);
				$modelDetail=$model->findAll($criteria);
				$this->render('formPurchaseDetail',array(
				'modelDetail'=>$modelDetail,'model'=>$model
				));

		}
	}


	public function actionGetProductJson()
	{
	
	$term=$_REQUEST['term'];
	    if(isset($term))
	    {
	         $request=trim($term);

	        $model=Product::model()->findAll(array("condition"=>"product_name like '%$request%'"));
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
