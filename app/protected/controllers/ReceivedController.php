<?php

class ReceivedController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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




	public function actionGetPOJson()
	{
		$term=$_REQUEST['term'];
	    if(isset($term))
	    {
	        $request=trim($term);
	        $criteria=new CDbCriteria();
	        $criteria->select ="po_no,id";
	        $criteria->condition="po_no like :request";
	        $criteria->params=array(':request'=> '%'.$request.'%');
	        $criteria->limit=30;
	        $model=Purchaseorder::model()->findAll($criteria);

	        $data=array();
	        foreach($model as $get)
	        {
	            $data[]=array('label' => $get->po_no,'id'=>$get->id);
	        }
	        $this->layout='empty';
	        echo json_encode($data);
	    }

	}

		

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionReceive()
	{
		$model=new Received;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Received']))
		{
			$dataPost=$_POST['Received'];
		 	$sdate= explode("/", $dataPost["receive_date"]);
		 	$receiveDate=$sdate[2].'-'.$sdate[1].'-'.$sdate[0];
		 	$po_id=$_POST['po_id'];
			
			$model->attributes=$_POST['Received'];
			$model->po_id=$po_id;
			$model->receive_date=$receiveDate;
			if($model->save())
			{
			    $purchasedetails=Yii::app()->db->createCommand()
                ->select("pd.id,tp.product_name,tp.product_id AS item_id,pd.qty,pd.price,tp.product_code")
                ->from('tbl_purchasedetail pd')
                ->join('tb_product tp','pd.Item_id=tp.product_id')
                ->where('pd.PurchaseOrder_id=:id',array(':id'=>$po_id))
                ->queryAll(); 

    			foreach($purchasedetails as $d)
    			{
					$receivetran=new Receivetransaction();
					$receivetran->item_id=$d["item_id"];
					$receivetran->purchase_qty=$d["qty"];
					$receivetran->received_id=$model->id;
					$receivetran->receive_qty=$d["qty"];
					$receivetran->status=0;
					$receivetran->POdetail_id=$d["id"];
					$receivetran->save();
    		    }
    		    $this->redirect(array('receive','receive_id'=>$model->id));
			}
		}

		$receive_id= Yii::app()->request->getParam('receive_id');
		if(isset($receive_id))
		{

			$modelReceived=$model->findByPk($receive_id);
			$this->render('ReceivedForm',array(
			'model'=>$modelReceived,'receive_id'=>$receive_id));
		}
		else
		{
			$this->render('ReceivedForm',array(
			'model'=>$model,
			));
		}


	}

	

	/**
	 * Performs the AJAX validation.
	 * @param Received $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='received-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
