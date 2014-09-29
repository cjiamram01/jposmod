<?php

class PartialController extends Controller
{
  public $layout = '//layouts/partialLayout';
  
  public function actionProductList()
  {
  	$groupCode=Yii::app()->request->getParam('groupCode');
  	$groupLevel=Yii::app()->request->getParam('groupLevel');

  	$product = new Product();
    $model = new CActiveDataProvider($product, array(
        'sort' => array(
            'defaultOrder' => 'product_id DESC'
        )
    ));

    $pagination = new CPagination();
    $pagination->setPageSize(40);

    if(isset($groupLevel))
    {
    	 $criteria = new CDbCriteria();
    			
    			switch($groupLevel)
    			{
    				case 0:
    				{
    					$criteria->condition="product_dimension=:groupCode";
 						$criteria->params=array(':groupCode'=>$groupCode);
    				}
    				break;
    				case 1:
    				{
    					$criteria->condition="group_1=:groupCode";
 						$criteria->params=array(':groupCode'=>$groupCode);
    				}
    				break;
    				case 2:
    				{
    					$criteria->condition="group_2=:groupCode";
 						$criteria->params=array(':groupCode'=>$groupCode);
    				}
    				break;
    				case 3:
    				{
    					$criteria->condition="group_3=:groupCode";
 						$criteria->params=array(':groupCode'=>$groupCode);
    				}
    				break;
    				case 4:
    				{
    					$criteria->condition="group_4=:groupCode";
 						$criteria->params=array(':groupCode'=>$groupCode);
    				}
    				break;
    			}

    $model->setCriteria($criteria);

    }

    $model->setPagination($pagination);

    $this->render('//Partial/ProductList', array(
        'model' => $model
    ));
  }
  

  public function actionGenerateTreeview()
  {
  	
    
    $tree=new TreeMenu();
    $array=array();
    $dimCode=Yii::app()->request->getParam('dimCode');
    if(isset($dimCode))
    	{$array=$tree->getTreeData($dimCode); }    
    $this->render('//Partial/TreeView',array('categoriesData'=>$array));
  }

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}