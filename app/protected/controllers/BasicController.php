<?php

class BasicController extends Controller {

  function actionChangeProfile() {
    $pk = Yii::app()->request->cookies["user_id"]->value;
    $model = User::model()->findByPk($pk);

    if ($_POST != null) {
      $model->attributes = $_POST["User"];

      if ($model->save()) {
        $this->redirect(array('Site/index'));
      }
    }

    $this->render('//Basic/ChangeProfile', array(
        'model' => $model
    ));
  }

  public function actionWriteJsonLevel()
  {
     $strJson="{\n";
     $strJson.="\"root\": [\n";

        $crt0=new CDbCriteria();
        $crt0->select="id,group_code,DESCRIPTION";
        $crt0->condition="LEVEL=0";
        $Ms0=Itemgroup::model()->findAll($crt0);
        //***********Start Parent Heirachy************* 
        $i0=0;
        if(count($Ms0)>0)
        {
          foreach($Ms0 as $m0)
          {
              $i0++;
            //********************Query level 1**************
              $crt1=new CDbCriteria();
              $crt1->select="id,group_code,DESCRIPTION";
              $crt1->condition="LEVEL=1 AND group_code=:parent_code";
              $crt1->params=array(':parent_code'=>$m0->group_code);
              $Ms1=Itemgroup::model()->findAll($crt1);
              if(count($Ms1)>0)
              {
               
                $strJson.="\t\t\t{\n\t\t\t\t\"<a href='#'>".str_replace('"', '',$m0->DESCRIPTION)."</a>\":[\n";
                $i1=0;
                foreach($Ms1 as $m1)
                 {
                    $i1++;

                    /*******Query Level 2************/
                      $crt2=new CDbCriteria();
                      $crt2->select="id,group_code,DESCRIPTION";
                      $crt2->condition="LEVEL=2 AND group_code=:parent_code";
                      $crt2->params=array(':parent_code'=>$m1->group_code);
                      $Ms2=Itemgroup::model()->findAll($crt2);
                    /*******************************/
                      if(count($Ms2)>0)
                      {
                          $i2=0;
                          foreach($Ms2 as $m2)
                          {
                             $i2++;
                               /*******Query Level 2************/
                                $crt3=new CDbCriteria();
                                $crt3->select="id,group_code,DESCRIPTION";
                                $crt3->condition="LEVEL=3 AND group_code=:parent_code";
                                $crt3->params=array(':parent_code'=>$m2->group_code);
                                $Ms3=Itemgroup::model()->findAll($crt2);
                              /*******************************/
                                 if(count($Ms3)>0)
                                 {
                                    $i3=0;
                                    $strJson.="\t\t\t\t\t\"<a href='#'>".str_replace('"', '',$m2->DESCRIPTION)."</a>\":[";
                                    $strJson.="\t\t\t\t\t\t{";
                                      foreach($Ms3 as $m3)
                                        {
                                          $i3++;
                                          $strJson.=$i3<count($Ms3)?"\t\t\t\t\t\t\t<a href='#'>".str_replace('"', '',$m3->DESCRIPTION)."</a>,\n":"\t\t\t\t\t\t\t<a href='#'>".str_replace('"', '',$m3->DESCRIPTION)."</a>\n";
                                        }
                                    $strJson.=$i2<count($Ms2)?"\t\t\t\t\t\t},\n":"\t\t\t\t\t\t}\n";
                                    $strJson.="\t\t\t\t\t]\n";
                                 }
                                 else
                                    $strJson.=$i2<count($Ms2)?"\t\t\t\t\t\"<a href='#'>".str_replace('"', '',$m2->DESCRIPTION)."</a>\",\n":"\t\t\t\t\t\"<a href='#'>".str_replace('"', '',$m2->DESCRIPTION)."</a>\"\n";

                          }
                      }
                      else
                      {
                        $strJson.=$i1<count($Ms1)?"\t\t\t\t\"<a href='#'>".str_replace('"', '',$m1->DESCRIPTION)."</a>\",\n":"\t\t\t\t\"<a href='#'>".str_replace('"', '',$m1->DESCRIPTION)."</a>\"\n";

                      }
                 } 
                $strJson.=$i0<count($Ms0)?"\t\t\t\t\t]\n\t\t\t},\n":"\t\t\t\t\t]\n\t\t\t}\n";
              }
              else
              {
                $strJson.=$i0<count($Ms0)?"\t\t\t\"<a href='#'>".str_replace('"', '',$m0->DESCRIPTION)."</a>\",\n":"\t\t\t\"<a href='#'>".str_replace('"', '',$m0->DESCRIPTION)."</a>\"\n";
              }

            //********************End Query Level 1**********
          }
           
        }

         //***********End Parent Heirachy************* 


     $strJson.="]\n";
     $strJson.="}";


    $fp = fopen('ItemGroup7.json', 'w');
    fwrite($fp, $strJson);

    fclose($fp);
  }

  public function actionWriteJsonItemGroup()
  {
    $strJson="{\n";
    $strJson.=" \"root\": [\n";
    $crt1=new CDbCriteria();
    $crt1->select="id,group_code,DESCRIPTION";
    $crt1->condition="LEVEL=0";
    $Ms1=Itemgroup::model()->findAll($crt1);
    //***********Start Parent Heirachy************* 
    $i1=0;
    foreach($Ms1 as $m1)
    {
      $i1++;
      $strJson.="\t\t{\n";
      $strDesc=str_replace('"', '', $m1->DESCRIPTION);
      $strJson.= "\t\t\t\"ชื่อกลุ่มที่ 0 :\"".$strDesc."\"";

      //***********Start first child*******
      $crt2=new CDbCriteria();
      $crt2->select="id,group_code,DESCRIPTION";
      $crt2->condition="LEVEL=1 AND parent_code=:parent_code";
      $crt2->params=array(':parent_code'=>$m1->group_code);
      $Ms2=Itemgroup::model()->findAll($crt2);
      if(count($Ms2)>0)
      {
        $strJson.=",\n";
        $strJson.="\t\t\t\t\"ลำดับที่ 1\": [\n";
        $i2=0;
        foreach($Ms2 as $m2)
        {
          $i2++;
          $strJson.="\t\t\t\t\t{\n";
          $strDesc=str_replace('"', '', $m2->DESCRIPTION);
          $strJson.= "\t\t\t\t\t\t\"".$strDesc."\"";
          
          //****************Start second child******
            $crt3=new CDbCriteria();
            $crt3->select="id,group_code,DESCRIPTION";
            $crt3->condition="LEVEL=2 AND parent_code=:parent_code";
            $crt3->params=array(':parent_code'=>$m2->group_code);
            $Ms3=Itemgroup::model()->findAll($crt3);
            if(count($Ms3)>0)
            { 
              $strJson.=",\n";
              $i3=0;
              $strJson.="\t\t\t\t\t\t\t: [\n";
              foreach($Ms3 as $m3)
              {
                $i3++;
                $strJson.="\t\t\t\t\t\t\t\t{\n";
                $strDesc=str_replace('"', '', $m3->DESCRIPTION);
                $strJson.= "\t\t\t\t\t\t\t\t\t\"".$strDesc."\"\n";
                $strJson.=$i3<count($Ms3)?"\t\t\t\t\t\t\t\t},\n":"\t\t\t\t\t\t\t\t}\n";
              }
              $strJson.="\t\t\t\t\t\t\t]\n";
            }

          //****************************************
          $strJson.=$i2<count($Ms2)?"\t\t\t\t\t},\n":"\t\t\t\t\t}\n";

        }
        $strJson.="\t\t\t\t]\n";
      }

      //***********************************
      
      $strJson.=$i1<count($Ms1)?"\t\t},\n":"\t\t}\n";
    }
    //***********End Parent Heirachy*************

    $strJson.="\t]\n";  
    $strJson.="}\n";

    $fp = fopen('ItemGroup4.json', 'w');
    fwrite($fp, $strJson);

    fclose($fp);

  }

  

  function actionBillImport($id = null) {
    $model = new BillImport();

    // SAVE DATA
    if (!empty($_POST)) {
      $pk = $_POST['BillImport']['bill_import_code'];

      if (!empty($pk)) {
        // FIND BILL
        $model = BillImport::model()->findByPk($pk);
      }

      // VARIABLE
      $import_pay_date = $_POST['BillImport']['bill_import_pay_date'];
      $import_created_date = $_POST['BillImport']['bill_import_created_date'];

      $import_pay_date = Util::thaiToMySQLDate($import_pay_date);
      $import_created_date = Util::thaiToMySQLDate($import_created_date);

      $model->attributes = $_POST['BillImport'];
      $model->bill_import_pay_date = $import_pay_date;
      $model->bill_import_created_date = $import_created_date;

      // PAY AND SAVE
      $import_pay_status = $_POST["BillImport"]["bill_import_pay_status"];
			
      if ($import_pay_status == "pay" && $import_pay_date == "") {
        $model->bill_import_pay_date = new CDbExpression("NOW()");
      }
			
      if ($model->save()) {
        $this->redirect(array('BillImport'));
      }
    }

    // BILL IMPORT
    $billImport = new BillImport();
    $modelForGrid = new CActiveDataProvider($billImport, array(
        'sort' => array('defaultOrder' => 'bill_import_created_date DESC')
    ));

    // DATA FOR EDIT
    if (!empty($id)) {
      $model = BillImport::model()->findByPk($id);
			
			$created_date = $model->bill_import_created_date;
			$pay_date = $model->bill_import_pay_date;
			
			$model->bill_import_created_date = Util::mysqlToThaiDate($created_date);
			$model->bill_import_pay_date = Util::mysqlToThaiDate($pay_date);
    }

    // RENDER PAGE
    $this->render('//Basic/BillImport', array(
        'model' => $model,
        'modelForGrid' => $modelForGrid
    ));
  }

  // DELETE BILL IMPORT
  public function actionBillImportDelete($id) {
    BillImport::model()->deleteByPk($id);
    $this->redirect(array('BillImport'));
  }

  // BILL IMPORT DETAIL
  public function actionBillImportDetail($bill_import_code = null, $id = null) {
    
    // CHECK $bill_import_code
    if (empty($bill_import_code)) {
      $bill_import_code = $_POST['BillImportDetail']['bill_import_code'];
    }

    // CREATE OBJECT OF BillImport
    $modelBillImport = BillImport::model()->findByPk($bill_import_code);
    $modelBillImportDetail = new BillImportDetail();
    $modelBillImportDetail->bill_import_code = $bill_import_code;

    // SAVE
    if (!empty($_POST)) {
      $pk = $_POST['BillImportDetail']['bill_import_detail_id'];
      $bill_import_code = $_POST['BillImportDetail']['bill_import_code'];

      // CREATE OBJECT OF BillImportDetail
      if (!empty($pk)) {
        $model = BillImportDetail::model()->findByPk($pk);
      } else {
        $model = new BillImportDetail();
      }

      // QTY
      $qty = $_POST['BillImportDetail']['import_bill_detail_product_qty'];
      $qty_before = $_POST['qty_before'];
      $newQty = 0;

      if (!empty($qty_before)) {
        if ($qty_before > $qty) {
          // -
          $newQty = -($qty_before - $qty);
        } else {
          // +
          $newQty = ($qty - $qty_before);
        }
      }

      // UPDATE STOCK 
      $codeProduct = $_POST['BillImportDetail']['product_id'];
      $attribute = array();
      $attribute['product_code'] = $codeProduct;
      $product = Product::model()->findByAttributes($attribute);

      if (!empty($pk)) {
        $product->product_quantity += $newQty;
      } else {
        $product->product_quantity += $qty;
      }
      $product->save();

      // SAVE bill_import_detail
      $model->attributes = $_POST["BillImportDetail"];
      $model->import_bill_detail_qty = ($qty * $product->product_total_per_pack);
      $model->product_id = $product->product_id;

      // DEFAULT PRICE
      if (empty($_POST['BillImportDetail']['import_bill_detail_price'])) {
        $model->import_bill_detail_price = $product->product_price;
      }

      // SAVE
      if ($model->save()) {
        $this->redirect(array(
            'BillImportDetail', 
            'bill_import_code' => $bill_import_code
        ));
      }
    }

    // DATA FOR EDIT
    if (!empty($id)) {
      $modelBillImportDetail = BillImportDetail::model()->findByPk($id);
    }

    // RENDER
    $this->render('//Basic/BillImportDetail', array(
        'modelBillImport' => $modelBillImport,
        'model' => $modelBillImportDetail
    ));
  }

  // BILL IMPORT DETAIL DELETE
  public function actionBillImportDetailDelete($id, $bill_import_code) {
    // model
    $model = BillImportDetail::model()->findByPk($id);
    $qty = $model->import_bill_detail_product_qty;

    // update stock
    $model->product->product_quantity -= $qty;
    $model->product->save();

    // delete
    $model->deleteByPk($id);
    $this->redirect(array('BillImportDetail',
        'bill_import_code' => $bill_import_code
    ));
  }

	// SALE
  public function actionSale() {
    $model = new BillSale();

    if (!empty($_POST)) {
      //echo $_POST;
      Yii::app()->session['sessionBillSale'] = $_POST;

      // BILL SALE DETAIL
      $arrayBillSaleDetail = Yii::app()->session['billSaleDetail'];

      if (empty($arrayBillSaleDetail)) {
        $arrayBillSaleDetail = array();
      }
      $size = count($arrayBillSaleDetail);

      // ADD bill_sale_detail ITEMS
      $productCode = $_POST['product_code'];
      $code = "";
      $price = 0;
      $qty_per_pack = 0;

      $product = Product::model()->findByAttributes(array(
          'product_code' => $productCode
      ));

      $sale_condition = $_POST['sale_condition'];

      if (empty($product)) {
        $product = Product::model()->findByAttributes(array(
            'product_pack_barcode' => $productCode
        ));

        if (!empty($product)) {
          $code = $product->product_pack_barcode;
          $price = $product->product_price_per_pack;
          $qty_per_pack = $product->product_total_per_pack;
        }
      } else {
        // FIND PRICE OF PRODUCT
        if ($sale_condition == 'many') {
          $price = $product->product_price_send;
        } else {
          $price = $product->product_price;
        }

        $code = $product->product_code;
        $qty_per_pack = 1;
      }

      // FOUND PRODUCT
      if (!empty($product)) {
        $arrayBillSaleDetail[$size] = array(
            'product_qty' => $_POST['product_qty'],
            'product_code' => $code,
            'product_name' => $product->product_name,
            'product_price' => $price,
            'product_serial_no' => $_POST['product_serial_no'],
            'product_expire_date' => $_POST['product_expire_date'],
            'product_qty_per_pack' => $qty_per_pack,
            'sale_status' => $_POST['sale_status'],
            'sale_condition' => $_POST['sale_condition'],
            'has_bonus' => 'normal'
        );

        Yii::app()->session['billSaleDetail'] = $arrayBillSaleDetail;
        $this->redirect(array('Sale'));
      }
    }

    // RENDER
    $this->render('//Basic/Sale', array(
        'model' => $model
    ));
  }

  public function actionPurchaseDetailDelete($pid)
  {
    $id= Yii::app()->request->getParam('id');
     if(isset($id))
    {
        $purchaseDetail=Purchasedetail::model()->findByPk($pid);
        $purchaseDetail->delete();  
        $this->redirect(array('basic/PO','id'=>$id));
    }

  }

	// SALE DELETE
  public function actionSaleDelete($index) {
    $billSaleDetail = Yii::app()->session['billSaleDetail'];

    // remove product item from array
    for ($i = 0; $i < count($billSaleDetail); $i++) {
      if ($i == $index) {
        $billSaleDetail[$i] = null;
      }
    }

    // clear empty array item
    $newArray = array();
    for ($i = 0; $i < count($billSaleDetail); $i++) {
      if (!empty($billSaleDetail[$i])) {
        $newArray[count($newArray)] = $billSaleDetail[$i];
      }
    }

    // add new array to session
    Yii::app()->session['billSaleDetail'] = $newArray;
    $this->redirect(array('Sale'));
  }


  

  public function actionChooseItem()
  {
    $modelDetail=new Purchasedetail();
    if(isset($_POST['Purchasedetail']))
    {
      $product_id=$_POST['product_id'];
      $modelDetail->item_id=$product_id;
      $id= Yii::app()->request->getParam('id');
      $model->PurchaseOrder_id=$id;
      if(isset($id))
      {
        if($model->save())
          $this->redirect(array('//basic/PO','id'=>$id));       
      }
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

          $this->redirect(array('//basic/PO','id'=>$id)); 
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

  public function actionShiping()
  {

      $model =new Shiping();

      $this->render('//shiping/ShipingForm',array('model'=>$model,));

  }

	// END SALE
  public function actionEndSale() {
    if (!empty(Yii::app()->session['billSaleDetail'])) {
      // loop data from session to database
      Yii::app()->session['sessionBillSale'] = $_POST;
      $billSaleDetail = Yii::app()->session['billSaleDetail'];

      // find member_id
      $member_code = $_POST['member_code'];
      $criteria = new CDbCriteria();
      $criteria->compare('member_code', $member_code);
      $member = Member::model()->find($criteria);

      if (!empty($member)) {
        $member_id = $member->member_id;
      } else {
        $member_id = 0;
      }

      // sale_status
      if ($_POST['sale_status'] == 'cash') {
        $saleStatus = 'pay';
      } else {
        $saleStatus = 'credit';
      }

      // bill sale
      $modelBillSale = new BillSale();
      $modelBillSale->bill_sale_created_date = new CDbExpression('NOW()');
      $modelBillSale->bill_sale_status = $saleStatus;
      $modelBillSale->member_id = $member_id;
      $modelBillSale->bill_sale_vat = $_POST['bill_sale_vat'];
      $modelBillSale->user_id = Yii::app()->request->cookies['user_id']->value;
      $modelBillSale->branch_id = $_POST['BillSale']['branch_id'];

      if ($_POST['sale_status'] == 'cash') {
        $modelBillSale->bill_sale_pay_date = new CDbExpression('NOW()');
      }

      if ($modelBillSale->save()) {
				
        // store data bill_sale_detail from session to database
        foreach ($billSaleDetail as $r) {
          $model = new BillSaleDetail();
          $model->bill_id = $modelBillSale->bill_sale_id;
          $model->bill_sale_detail_barcode = $r['product_code'];
          $model->bill_sale_detail_price = $r['product_price'];
          $model->bill_sale_detail_qty = $r['product_qty'];
          $model->bill_sale_detail_price_vat = ($r['product_price'] * .07);
          $model->bill_sale_detail_type = $r['sale_condition'];
          $model->bill_sale_detail_has_bonus = $r['has_bonus'];

          $model->save();

          // sub stock
          $product_code = $r['product_code'];

          // find by barcode
          $product = Product::model()->findByAttributes(array(
              'product_code' => $product_code
          ));

          if (empty($product)) {
            // find by pack barcode
            $product = Product::model()->findByAttributes(array(
                'product_pack_barcode' => $product_code
            ));
          }

					$qty = ($product->product_quantity - $r['product_qty_per_pack']);
          $product->product_quantity = $qty;
          $product->save();

          // save to tb_product_serial
          if (!empty($r['product_serial_no'])) {
            $productSerial = new ProductSerial();
            $productSerial->_attributes = array(
                'product_code' => $r['product_code'],
                'serial_no' => $r['product_serial_no'],
                'product_start_date' => new CDbExpression('NOW()'),
                'bill_sale_id' => $modelBillSale->bill_sale_id
            );

            // expire date
            if (!empty($r['product_expire_date'])) {
							$expire_date = Util::thaiToMySQLDate($r['product_expire_date']);
							$productSerial->product_expire_date = $expire_date;
            }
            
            $productSerial->save();
          }
        }

        // keep last bill_id
        Yii::app()->session['last_bill_sale_id'] = $modelBillSale->bill_sale_id;

        // clear bill_sale_temp
        BillSaleTemp::model()->deleteAll();
        unset(Yii::app()->session['billSaleDetail']);

        // redirect
        $this->redirect(array('Sale'));
      }
    }
  }

	// END SALE TEMP DATA
  public function actionEndSaleTempData() {
    Yii::app()->session['total'] = $_POST['total'];
    Yii::app()->session['input'] = $_POST['input'];
    Yii::app()->session['returnMoney'] = $_POST['returnMoney'];
  }

	// SALE RESET
  public function actionSaleReset() {
    Yii::app()->session['billSaleDetail'] = null;
    Yii::app()->session['sessionBillSale'] = null;
    Yii::app()->session['total'] = null;
    Yii::app()->session['input'] = null;
    Yii::app()->session['returnMoney'] = null;

    $this->redirect(array('Sale'));
  }

	// MANAGE BILL
  public function actionManageBill() {
		// BILL SALE OBJECT
    $billSale = new BillSale();
		
		// CONDITION
    $criteria = new CDbCriteria();
    $criteria->order = 'bill_sale_id DESC';
    $criteria->condition = "bill_sale_status = 'credit'";

    $modelForGrid = new CActiveDataProvider('BillSale', array(
        'criteria' => $criteria
    ));
		
		// RENDER
    $this->render('//Basic/ManageBill', array(
        'model' => $billSale,
        'modelForGrid' => $modelForGrid
    ));
  }

	// BILL SALE DETAIL
  public function actionBillSaleDetail($bill_sale_id) {
    // MODEL
    $modelBillSale = BillSale::model()->findByPk($bill_sale_id);

    // dataProvider
    $dataProvider = new CActiveDataProvider('BillSaleDetail', array(
        'criteria' => array(
            'condition' => "bill_id = $bill_sale_id",
            'order' => 'bill_sale_detail_id DESC'
        ),
        'pagination' => false
    ));

    // RENDER
    $this->render('//Basic/BillSaleDetail', array(
        'modelBillSale' => $modelBillSale,
        'dataProvider' => $dataProvider
    ));
  }

	// EDIT BILL SALE DETAIL
  public function actionBillSaleDetailEdit($bill_sale_detail_id = null) {
    if (empty($bill_sale_detail_id)) {
      $bill_sale_detail_id = $_POST['bill_sale_detail_id'];
    }
    
    $model = BillSaleDetail::model()->findByPk($bill_sale_detail_id);

    // update bill_sale_detail
    if (!empty($_POST)) {
      $old_qty = $_POST['old_qty'];
      $new_qty = $_POST['BillSaleDetail']['bill_sale_detail_qty'];
      $model->bill_sale_detail_qty = $new_qty;
      $model->save();

      // update stock
      $product_code = $model->bill_sale_detail_barcode;
      $product = Product::model()->find(array(
          'condition' => "product_code = '$product_code'"
      ));
      
      if ($new_qty > $old_qty) {
        $update_qty = ($new_qty - $old_qty);
        $product->product_quantity += $update_qty;
      } else {
        $update_qty = ($old_qty - $new_qty);
        $product->product_quantity -= $update_qty;
      }
      
      $product->save();
      $this->redirect(array('BillSaleDetail', 'bill_sale_id' => $model->bill_id));
    }

    // REDIRECT
    $this->render('BillSaleEdit', array(
      'bill_sale_id' => $model->bill_id,
      'model' => $model
    ));
  }

	// DELETE BILL SALE DETAIL
  public function actionBillSaleDetailDelete($bill_sale_detail_id) {
    // OBJECT
    $billSaleDetail = BillSaleDetail::model()->findByPk($bill_sale_detail_id);
    $bill_sale_id = $billSaleDetail->bill_id;

    $criteria = new CDbCriteria();
    $criteria->compare('bill_id', $bill_sale_id);
    $model = BillSaleDetail::model()->findAll($criteria);

    $totalRow = count($model);

    // UPDATE STOCK
    $criteria = new CDbCriteria();
    $criteria->compare('product_code', $billSaleDetail->bill_sale_detail_barcode);
    $product = Product::model()->find($criteria);

    $product->product_quantity = ($product->product_quantity + $billSaleDetail->bill_sale_detail_qty);
    $product->save();

    // DELETE
    $billSaleDetail->delete();

    if ($totalRow == 1) {
      // DELETE BILL_SALE
      BillSale::model()->deleteByPk($bill_sale_id);
      $this->redirect(array('ManageBill'));
    }

    // REDIRECT FOR MANAGE BILL_SALE_DETAIL
    $this->redirect(array('BillSaleDetail', 'bill_sale_id' => $bill_sale_id));
  }

	// CHECK STOCK
  public function actionCheckStock() {
    $model = new Product();
    $param = array();
    $param['model'] = $model;
    $param['product_code'] = "";

    // find product
    if (!empty($_POST)) {
      $product = Product::model()->findByAttributes(array(
          'product_code' => $_POST['Product']['product_code']
      ));

      // find by pack_code
      if (empty($product)) {
        $product = Product::model()->findByAttributes(array(
            'product_pack_barcode' => $_POST['Product']['product_code']
        ));
      }

      $param['product'] = $product;
      $param['product_code'] = $_POST['Product']['product_code'];
    }

    // render
    $this->render('//Basic/CheckStock', $param);
  }

	// BILL DROP
  public function actionBillDrop() {
    $model = new BillSale();
    $params = array();

    if (!empty($_POST)) {
      // get value
      $from = Util::thaiToMySQLDate($_POST['from']);
      $to = Util::thaiToMySQLDate($_POST['to']);
      $bill_status = $_POST['bill_status'];

      // find member id
      $member = Member::model()->findByAttributes(array(
          'member_code' => $_POST['member_code']
      ));

      // criteria
      $criteria = new CDbCriteria();
      $criteria->order = 'bill_sale_created_date DESC ';
      $criteria->condition = ' (bill_sale_status = :bill_sale_status) ';
      $criteria->condition .= ' AND (member_id = :member_id)';
      $criteria->condition .= ' AND DATE(bill_sale_created_date) BETWEEN :from AND :to';

      // filter bill status
      switch ($bill_status) {
        case 'no':
          $criteria->condition .= ' AND bill_sale_pay_date IS NULL ';
          $criteria->condition .= ' AND bill_sale_drop_bill_date IS NULL ';
          break;
        case 'drop_no':
          $criteria->condition .= ' AND bill_sale_pay_date IS NULL ';
          $criteria->condition .= ' AND bill_sale_drop_bill_date IS NOT NULL ';
          break;
        case 'drop_pay':
          $criteria->condition .= ' AND bill_sale_pay_date IS NOT NULL ';
          $criteria->condition .= ' AND bill_sale_drop_bill_date IS NOT NULL ';
          break;
      }

      // params
      $criteria->params = array(
          'bill_sale_status' => 'credit',
          'member_id' => $member->member_id,
          'from' => $from,
          'to' => $to
      );

      // data provider
      $dataProvider = new CActiveDataProvider('BillSale', array(
          'criteria' => $criteria,
          'pagination' => false
      ));

      // have data
      $params['dataProvider'] = $dataProvider;
    } else {
      $from = "";
      $to = "";
    }

    $params['from'] = $from;
    $params['to'] = $to;
    $params['model'] = $model;
    $params['member_code'] = @$_POST['member_code'];
    $params['member_name'] = @$_POST['member_name'];
    $params['bill_status'] = @$_POST['bill_status'];

    $this->render('//Basic/BillDrop', $params);
  }

	// BILL DROP TEMP
  public function actionBillDropTemp() {
    Yii::app()->session['hidden_member_code'] = $_POST['hidden_member_code'];
    Yii::app()->session['bill_sale_ids'] = $_POST['bill_sale_id'];

    echo 'complete';
  }

	// BILL DROP GET
  public function actionBillDropGet() {
    $bill_sale_ids = $_POST['bill_sale_id'];

    foreach ($bill_sale_ids as $id) {
      $model = BillSale::model()->findByPk($id);
      $model->bill_sale_pay_date = new CDbExpression("NOW()");
      $model->save();
    }

    echo true;
  }

	// BILL DROP CANCEL
  public function actionBillDropCancel() {
    $bill_sale_ids = $_POST['bill_sale_id'];

    foreach ($bill_sale_ids as $id) {
      $model = BillSale::model()->findByPk($id);
      $model->bill_sale_pay_date = null;
      $model->bill_sale_drop_bill_date = null;
      $model->bill_sale_status = 'credit';
      $model->save();
    }

    echo true;
  }
  
  // BILL DROP DELETE
  public function actionBillDropDelete() {
    $bill_sale_ids = $_POST['bill_sale_id'];

    foreach ($bill_sale_ids as $id) {
      $billSaleDetails = BillSaleDetail::model()->findAllByAttributes(array(
      		'bill_id' => $id
      ));
      
      foreach ($billSaleDetails as $billSaleDetail) {
	     	$billSaleDetail->delete(); 
      }
      
      BillSale::model()->deleteByPk($id);
    }

    echo true;
  }

	// GET SALE
  public function actionGetSale() {
    $model = new BillSaleDetail();
    $product = null;

    // search
    if (!empty($_POST)) {
			$barcode = $_POST['BillSaleDetail']['bill_sale_detail_barcode'];
			
      if (empty($_POST['product_id'])) {
        // find data
        $billSaleDetail = BillSaleDetail::model()->findByAttributes(array(
            'bill_sale_detail_barcode' => $barcode,
            'bill_id' => $_POST['BillSaleDetail']['bill_id']
        ));
        $model->_attributes = $_POST['BillSaleDetail'];

        // find by product_id
        if (!empty($billSaleDetail)) {
          $product = Product::model()->findByAttributes(array(
              'product_code' => $billSaleDetail->bill_sale_detail_barcode
          ));
          if (!empty($product)) {
            $model->bill_sale_detail_barcode = $product->product_code;
          }
        }
      } else {
        // get product                
        $product = Product::model()->findByPk($_POST['product_id']);

        // remove from bill
        BillSaleDetail::model()->deleteAllByAttributes(array(
            'bill_sale_detail_barcode' => $barcode,
            'bill_id' => $_POST['BillSaleDetail']['bill_id']
        ));

        // update stock and redirect
        $product->product_quantity += 1;
        $product->save();

        $this->redirect(array('GetSale'));
      }
    }

    // render
    $this->render('//Basic/GetSale', array(
        'model' => $model,
        'product' => $product
    ));
  }

	// REPAIR
  public function actionRepair() {
    $params = @$_POST;

    if (!empty($_POST)) {
      // search
      $search = $_POST['search_code'];

      if (empty($search)) {
        try 
        {
         //$search = $_GET['serial_code'];
        }
        catch(Exception $e)
        {

        }
      }

      // productSerial
      $productSerial = ProductSerial::model()->findByAttributes(array(
          'serial_no' => $search
      ));

      if (!empty($productSerial)) {
        $product = Product::model()->findByAttributes(array(
            'product_code' => $productSerial->product_code
        ));

        $params['product'] = $product;
        $params['productSerial'] = $productSerial;
      }

      // repair history
      $criteria = new CDbCriteria();
      $criteria->compare('serial_no', $_POST['search_code']);
      $criteria->order = 'repair_id DESC';

      $repairs = new CActiveDataProvider('Repair');
      $repairs->setCriteria($criteria);
      $params['repairs'] = $repairs;
    }

    $this->render('//Basic/Repair', $params);
  }

  function actionStartRepair() {
    $serial_code = $_GET['serial_code'];

    // product serial
    $productSerial = Yii::app()->db->createCommand()
            ->select('tb_product_serial.*, tb_product.product_name, tb_bill_sale.bill_sale_created_date')
            ->from('tb_product_serial')
            ->join('tb_product', 'tb_product.product_code = tb_product_serial.product_code')
            ->join('tb_bill_sale', 'tb_bill_sale.bill_sale_id = tb_product_serial.bill_sale_id')
            ->where('tb_product_serial.serial_no = ' . $serial_code)
            ->queryRow();

    // repair
    if (!empty($_GET['repair_id'])) {
      $repair = Repair::model()->findByPk($_GET['repair_id']);
    } else {
      $repair = new Repair();
    }

    // render
    $this->render('//Basic/StartRepair', array(
        'productSerial' => $productSerial,
        'repair' => $repair
    ));
  }

  function actionStartRepairSave() {
    if (!empty($_POST)) {
      // serail_code
      $serial_code = $_POST['Repair']['serial_no'];

      // save
      $state_new = true;

      if (empty($_POST['Repair']['repair_id'])) {
        $repair = new Repair();
      } else {
        $state_new = false;
        $repair = Repair::model()->findByPk($_POST['Repair']['repair_id']);
      }

      $repair->_attributes = $_POST['Repair'];
      $repair->user_id = $_POST['user_id'];
      $repair->repair_created_date = Util::thaiToMySQLDate($_POST['repair_created_date']);
      $repair->branch_id = $_POST['hidden_branch_id'];
      $repair->repair_date = Util::thaiToMySQLDate($_POST['Repair']['repair_date']);

      if ($repair->save()) {
        if ($state_new) {
          $this->redirect(array('Basic/StartRepair', 'serial_code' => $serial_code));
        } else {
          $this->redirect(array('Basic/Repair', 'serial_code' => $serial_code));
        }
      }
    }
  }

  function actionRepairView($repair_id) {
    $serial_code = $_GET['serial_code'];

    // product serial
    $productSerial = Yii::app()->db->createCommand()
            ->select('tb_product_serial.*, tb_product.product_name, tb_bill_sale.bill_sale_created_date')
            ->from('tb_product_serial')
            ->join('tb_product', 'tb_product.product_code = tb_product_serial.product_code')
            ->join('tb_bill_sale', 'tb_bill_sale.bill_sale_id = tb_product_serial.bill_sale_id')
            ->where('tb_product_serial.serial_no = ' . $serial_code)
            ->queryRow();

    // repair
    if (!empty($_GET['repair_id'])) {
      $repair = Repair::model()->findByPk($_GET['repair_id']);
    } else {
      $repair = new Repair();
    }

    // render
    $this->render('//Basic/RepairView', array(
        'productSerial' => $productSerial,
        'repair' => $repair
    ));
  }

}

