<?php

class ShipingController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Shiping;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Shiping']))
		{
		 $dataPost=$_POST['Shiping'];
		 $sdate= explode("/", $dataPost["shiping_date"]);
		 $shipingDate=$sdate[2].'-'.$sdate[1].'-'.$sdate[0];
		 $new_picture = CUploadedFile::getInstance($model, 'picture');
     	 $old_picture = $model->picture;


          $user_id = Yii::app()->request->cookies['user_id']->value;
          $model->user_id=$user_id;

         
	      
	      if (!empty($new_picture)) 
	      {
	        $model->picture = $new_picture;
	        $model->picture->saveAs('upload/shiping/' . $new_picture);

	        // remove old picture
	        if (file_exists('upload/shiping/' . $new_picture)) 
	        {
	          @unlink('upload/shiping/' . $old_picture);
	        }
	      }


			$model->attributes=$_POST['Shiping'];
			$model->shiping_date=$shipingDate;
			$model->status=0;
			if($model->save())
			{
 				$id=$model->id;
 				$this->redirect(array('create','id'=>$id)); 
			}
		}

		//With out post shiping

		$id= Yii::app()->request->getParam('id');
		if(isset($id))
		{
			
			if(isset($_POST["product_id"]))
			{
				/*Save model shiping detail*/
				$modelDetail=new Shipingdetail();
				$modelDetail->shiping_id=$id;
				$modelDetail->item_id=$_POST["product_id"];
				$modelDetail->qty=$_POST["qty"];
				$modelDetail->price=$_POST["price"];

				$model=$model->findByPk($id);
				if($modelDetail->save())
		        {

		         	 $this->render('ShipingForm',array(
					 'model'=>$model,'id'=>$id
				));		
		        }
		        
	    	}
	    	else
	    	{
	    		$modelDetail=new Shipingdetail();
	    		$criteria=new CDbCriteria();
        		$criteria->condition="shiping_id=:shiping_id";
        		$criteria->params=array(":shiping_id"=>$id);
        		$modelDetail=$modelDetail->findAll($criteria);

        		$model=$model->findByPk($id);

	    		$this->render('ShipingForm',array(
					'model'=>$model,'id'=>$id
				));		
	    	}

	         


		}
		else
		{
			//$modelDetail=new Shipingdetail();

			$this->render('ShipingForm',array(
				'model'=>$model,
			));
		}
			
	

	}

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

		if(isset($_POST['Shiping']))
		{
			$model->attributes=$_POST['Shiping'];
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
		$dataProvider=new CActiveDataProvider('Shiping');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}*/

	/**
	 * Manages all models.
	 */
	/*public function actionAdmin()
	{
		$model=new Shiping('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Shiping']))
			$model->attributes=$_GET['Shiping'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}*/

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Shiping the loaded model
	 * @throws CHttpException
	 */
	/*public function loadModel($id)
	{
		$model=Shiping::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}*/

	/**
	 * Performs the AJAX validation.
	 * @param Shiping $model the model to be validated
	 */
	/*protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shiping-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}*/

	public function actionGetCustomer()
	{
		$term=$_REQUEST['term'];
	    if(isset($term))
	    {
	        $request=trim($term);

	        $criteria=new CDbCriteria();
	        $criteria->select ="member_id,member_name";
	        $criteria->condition="member_name like :request";
	        $criteria->params=array(':request'=> '%'.$request.'%');
	        $criteria->limit=30;
	        $model=Member::model()->findAll($criteria);

	        $data=array();
	        foreach($model as $get)
	        {
	            $data[]=array('label' => $get->member_name,'id'=>$get->member_id);
	        }

	        $this->layout='empty';
	        echo json_encode($data);
	    }
	}
}
