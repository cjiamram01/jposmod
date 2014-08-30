<?php

class PurchaseorderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';


public function actionGetSupplierJson()
	{
	
		$term=$_REQUEST['term'];
	    if(isset($term))
	    {
	         $request=trim($term);

	        $criteria=new CDbCriteria();
	        $criteria->select ="farmer_name,farmer_id";
	        $criteria->condition="farmer_name like :request";
	        $criteria->params=array(':request'=> '%'.$request.'%');
	        $criteria->limit=30;
	        $model=Farmer::model()->findAll($criteria);

	        $data=array();
	        foreach($model as $get)
	        {
	            $data[]=array('label' => $get->farmer_name,'id'=>$get->farmer_id);
	        }

	        $this->layout='empty';
	        echo json_encode($data);
	    }

	}

  public function actionPO()
  {
   $model=new Purchaseorder();
   if(isset($_POST['Purchaseorder']))//Save when system to be post PO.
    {
       

      $pfrm=$_POST['Purchaseorder'];
      $model->Status=0;
      $date=date("Y-m-d H:i:s");
      $sdate= explode("/", $_POST['order_date']);
      $model->order_date=$sdate[2].'-'.$sdate[1].'-'.$sdate[0];
      $model->Comment="ok";
      $model->po_no=$pfrm['po_no'];
      $model->quotation_no=$pfrm['quotation_no'];
      $model->supplier_id=$_POST['hdnSuppId'];
      if($model->save())
      {
        $this->redirect(array('PO','id'=>$model->id));
      }
    }
    else
    if(isset($_POST["product_id"]))
    {
      $id= Yii::app()->request->getParam('id');
      if(isset($id))
      {
        $modelDetail=new  Purchasedetail();
        $modelDetail->Item_id=$_POST["product_id"];
        $modelDetail->PurchaseOrder_id=$id;
        $modelDetail->qty=$_POST["qty"];
        $modelDetail->price=$_POST["price"];

        if($modelDetail->save())
        {

          $this->redirect(array('PO','id'=>$id)); 
        }
       // print_r($modelDetail->getErrors());
      }
    }

    $id= Yii::app()->request->getParam('id');
    if(!isset($id))
    {
       $modelDetail=new Purchasedetail();
       $this->render('//purchaseorder/POForm',array('model'=>$model,'modelDetail'=>$modelDetail,));
    }
    else
    {
        $modelDetail=new Purchasedetail();
        $criteria=new CDbCriteria();
        $criteria->condition="PurchaseOrder_id=:PurchaseOrder_id";
        $criteria->params=array(":PurchaseOrder_id"=>$id);
        $modelDetail=$modelDetail->findAll($criteria);
        $this->render('//purchaseorder/POForm',array('model'=>$model,'modelDetail'=>$modelDetail,));

    }
  }


	/**
	 * @return array action filters
	 */
	/*public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}*/

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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	/*public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}*/

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	/*public function actionCreate()
	{
		$model=new Purchaseorder;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Purchaseorder']))
		{
			$model->attributes=$_POST['Purchaseorder'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}*/

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	/*public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Purchaseorder']))
		{
			$model->attributes=$_POST['Purchaseorder'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}*/

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	/*public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}*/

	/**
	 * Lists all models.
	 */
	/*public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Purchaseorder');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}*/

	/**
	 * Manages all models.
	 */
	/*public function actionAdmin()
	{
		$model=new Purchaseorder('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Purchaseorder']))
			$model->attributes=$_GET['Purchaseorder'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}*/

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Purchaseorder the loaded model
	 * @throws CHttpException
	 */
	/*public function loadModel($id)
	{
		$model=Purchaseorder::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}*/

	/**
	 * Performs the AJAX validation.
	 * @param Purchaseorder $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='purchaseorder-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	
}
