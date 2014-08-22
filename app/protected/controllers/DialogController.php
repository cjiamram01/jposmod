<?php

class DialogController extends CController {

  public $layout = '//layouts/dialog';

  public function actionDialogGroupProduct() {
    $criteria = new CDbCriteria();
    $criteria->order = 'group_product_name';

    $model = GroupProduct::model()->findAll($criteria);

    $this->render('//Dialog/DialogGroupProduct', array(
        'model' => $model
    ));
  }

 function actionDialogReprintBillVatPDF() {
    
    //$str=Yii::app()->urlManager->parseUrl(Yii::app()->request);
    //echo $str;
    /*$str =explode("/",$str);
    
     if(count($str)>0)
      $sale_bill_id= $str[count($str)-1];
    else
      $sale_bill_id=0;*/
    $sale_bill_id = Yii::app()->request->getParam('bill_id');
    //echo  $sale_bill_id;
    /*echo  $sale_bill_id;*/
    if(isset($sale_bill_id))
    {

        $org = Organization::model()->find();

        $criteria = new CDbCriteria();
        $criteria->condition="bill_sale_status='pay' and bill_sale_id=:bill_sale_id";
        $criteria->params=array(':bill_sale_id'=>$sale_bill_id);
        $billSale = BillSale::model()->find($criteria);

        $this->render('//Dialog/DialogBillAddVat', array(
            'org' => $org,
            'billSale' => $billSale
        ));
    }
  }


  public function actionDialogReprintPDF()
  {
    /*$str=Yii::app()->urlManager->parseUrl(Yii::app()->request);
    $str =explode("/",$str);
    if(count($str)>0)
      $sale_bill_id= $str[count($str)-1];
    else
      $sale_bill_id=0;*/

     $sale_bill_id = Yii::app()->request->getParam('bill_id');

    if(isset($sale_bill_id))
    {
      
    
    $criteria = new CDbCriteria();
    $criteria->condition='bill_sale_id=:bill_sale_id';
    $criteria->params=array(':bill_sale_id'=>$sale_bill_id);


    $billSale = BillSale::model()->find($criteria);

    // organization data
    $org = Organization::model()->find();

  
    $criteria = new CDbCriteria();
    $criteria->compare('bill_id', $sale_bill_id);

    $billSaleDetail = BillSaleDetail::model()->findAll($criteria);

    // member
    $criteria = new CDbCriteria();
    $criteria->compare('member_code', $billSale->member->member_code);

    $member = Member::model()->find($criteria);

    $this->renderPartial('//Report/BillSendProduct', array(
        'org' => $org,
        'billSale' => $billSale,
        'billSaleDetail' => $billSaleDetail,
        'member' => $member
    ));
    }
  }

  function actionDialogReprintBillVat()
  {
    $saleBill=new BillSale();
      $model = new CActiveDataProvider($saleBill, array(
        'sort' => array(
            'defaultOrder' => 'bill_sale_id DESC'
        )
      ));

    $pagination = new CPagination();
    $pagination->setPageSize(40);
    $model->setPagination($pagination);

     $printType=2;
    $this->render('//Dialog/DialogReprintBill', array(
        'model' => $model,'printType'=>$printType,
    ));
  }

  public function actionDialogTreeView()
  {
     $this->render('//Dialog/DialogTreeView', array('printType'=>0,));

  }



  public function actionDialogReprintBill()
  {
      $saleBill=new BillSale();
      $model = new CActiveDataProvider($saleBill, array(
        'sort' => array(
            'defaultOrder' => 'bill_sale_id DESC'
        )
      ));

    $pagination = new CPagination();
    $pagination->setPageSize(40);
    $model->setPagination($pagination);

    $printType=1;
   
    $this->render('//Dialog/DialogReprintBill', array(
        'model' => $model,'printType'=>$printType,
    ));

  }

  public function actionDialogProduct() {
    $product = new Product();
    $model = new CActiveDataProvider($product, array(
        'sort' => array(
            'defaultOrder' => 'product_id DESC'
        )
    ));

    $pagination = new CPagination();
    $pagination->setPageSize(40);

    $model->setPagination($pagination);

    $this->render('//Dialog/DialogProduct', array(
        'model' => $model
    ));
  }

  public function actionDialogMember() {
    $model = new CActiveDataProvider('Member', array(
        'pagination' => array(
            'pageSize' => 20
        )
    ));

    if (!empty($_POST)) {
      $search = $_POST['search'];
      $criteria = new CDbCriteria();
      $criteria->compare('member_code', $search, true, 'OR');
      $criteria->compare('member_name', $search, true, 'OR');
      $criteria->compare('member_tel', $search, true, 'OR');
      $criteria->compare('member_address', $search, true, 'OR');

      $model->setCriteria($criteria);
    }

    $this->render('//Dialog/DialogMember', array(
        'model' => $model
    ));
  }

  public function actionDialogSupplier()
  {
     $model = new CActiveDataProvider('Farmer', array(
        'pagination' => array(
            'pageSize' => 20
        )
    ));

    if (!empty($_POST)) {
      $search = $_POST['search'];
      $criteria = new CDbCriteria();
      $criteria->compare('farmer_name', $search, true, 'OR');
      $criteria->compare('farmer_tel', $search, true, 'OR');
      $criteria->compare('farmer_address', $search, true, 'OR');

      $model->setCriteria($criteria);
    }

    $this->render('//Dialog/DialogSupplier', array(
        'model' => $model
    ));
  }

  public function actionDialogEndSale() {
    $billSaleDetail = Yii::app()->session['billSaleDetail'];
    $total = 0;
    if(count($billSaleDetail)>0){
    foreach ($billSaleDetail as $r) {
      $total += ($r['product_price'] * $r['product_qty']);
    }

    $this->render('//Dialog/DialogEndSale', array(
        'total' => $total
    ));}
  }

  public function actionDialogPrintSlip() {
    // organization data
    $org = Organization::model()->find();

    // bill_sale data
    $criteria = new CDbCriteria();
    $criteria->order = 'bill_sale_id DESC';
    $criteria->limit = 1;
    $criteria->compare('bill_sale_status', 'pay');

    $billSale = BillSale::model()->find($criteria);

    // bill_sale_detail data
    $criteria = new CDbCriteria();
    $criteria->compare('bill_id', $billSale->bill_sale_id);

    $billSaleDetail = BillSaleDetail::model()->findAll($criteria);

    // render page
    $this->renderPartial('//Report/Slip', array(
        'org' => $org,
        'billSale' => $billSale,
        'billSaleDetail' => $billSaleDetail
    ));
  }

  public function actionDialogBillSendProduct() {
    // organization data
    $org = Organization::model()->find();

    // bill_sale data
    $criteria = new CDbCriteria();
    $criteria->order = 'bill_sale_id DESC';
    $criteria->limit = 1;
    $criteria->compare('bill_sale_status', 'pay');

    $billSale = BillSale::model()->find($criteria);

    // bill_sale_detail data
    $criteria = new CDbCriteria();
    $criteria->compare('bill_id', $billSale->bill_sale_id);

    $billSaleDetail = BillSaleDetail::model()->findAll($criteria);

    // member
    $criteria = new CDbCriteria();
    $criteria->compare('member_code', $billSale->member->member_code);

    $member = Member::model()->find($criteria);

    $this->renderPartial('//Report/BillSendProduct', array(
        'org' => $org,
        'billSale' => $billSale,
        'billSaleDetail' => $billSaleDetail,
        'member' => $member
    ));
  }

  public function actionDialogBillDrop() {
    // object
    $org = Organization::model()->find();
    $hidden_member_code = Yii::app()->session['hidden_member_code'];

    // member
    $member = Member::model()->findByAttributes(array(
        'member_code' => $hidden_member_code
    ));

    // update bill_sale
    $bill_sale_ids = Yii::app()->session['bill_sale_ids'];
    foreach ($bill_sale_ids as $id) {
      $model = BillSale::model()->findByPk($id);
      $model->bill_sale_drop_bill_date = new CDbExpression("NOW()");
      $model->save();
    }

    // render
    $this->renderPartial('//Report/BillDrop', array(
        'org' => $org,
        'member' => $member
    ));
  }

  function actionDialogSerial() {
    $model = Yii::app()->db->createCommand()
            ->select('tb_product_serial.*, tb_product.product_name')
            ->from('tb_product_serial')
            ->join('tb_product', 'tb_product.product_code = tb_product_serial.product_code')
            ->where("tb_product_serial.serial_no<>''")
            ->order('tb_product_serial.id DESC')

            ->queryAll();
    $productSerials = new CArrayDataProvider($model);

    $this->render('//Dialog/DialogSerial', array(
        'productSerials' => $productSerials
    ));
  }

  function actionDialogUser() {
    $model = new CActiveDataProvider('User', array(
        'pagination' => array(
            'pageSize' => 20
        )
    ));

    if (!empty($_POST)) {
      $search = $_POST['search'];
      $criteria = new CDbCriteria();
      $criteria->compare('user_name', $search, true, 'OR');
      $criteria->compare('user_tel', $search, true, 'OR');

      $model->setCriteria($criteria);
    }

    $this->render('//Dialog/DialogUser', array(
        'model' => $model
    ));
  }

  function actionDialogBranch() {
    $model = new CActiveDataProvider('Branch');
    $this->render('//Dialog/DialogBranch', array(
        'model' => $model
    ));
  }




  function actionDialogBillAddVat() {
    $org = Organization::model()->find();

    $criteria = new CDbCriteria();
    $criteria->order = 'bill_sale_id DESC';
    $criteria->limit = 1;
    $criteria->compare('bill_sale_status', 'pay');

    $billSale = BillSale::model()->find($criteria);

    $this->render('//Dialog/DialogBillAddVat', array(
        'org' => $org,
        'billSale' => $billSale
    ));
  }

  function actionReportSalePerDayPdf() {
    $params = array();

    $result = Yii::app()->session['result'];
    $date_find = Yii::app()->session['date_find'];

    if (!empty($result)) {
      $branch_id = Yii::app()->session['branch_id'];
      $params['result'] = $result;
      $params['date_find'] = Util::mysqlToThaiDate($date_find);
      $params['sale_condition_cash'] = Yii::app()->session['sale_condition_cash'];
      $params['sale_condition_credit'] = Yii::app()->session['sale_condition_credit'];
      $params['has_bonus_no'] = Yii::app()->session['has_bonus_no'];
      $params['has_bonus_yes'] = Yii::app()->session['has_bonus_yes'];
      $params['n'] = 1;
      $params['branch'] = Branch::model()->findByPk($branch_id);
    }

    $this->render('//Report/ReportSalePerDayPdf', $params);
  }

}

