<?php

class AjaxController extends Controller {
 
  

  public function actionGenerateBarCode() 
  {
    $barcode= Yii::app()->request->getParam('barcode');
    if(isset($barcode))
    {

      $barcode = new Barcode39($barcode);
      $barcode->draw();
    }
  }



  public function actionGetGroupProductInfo($group_product_code) {
    $attributes = array();
    $attributes["group_product_code"] = $group_product_code;

    $model = GroupProduct::model()->findByAttributes($attributes);
    echo CJSON::encode($model);
  }





  public function actionDuplicatedPO()
  {
    $strPath= Yii::app()->baseUrl;
    $poid=Yii::app()->request->getParam('pid');
    $purchasedetails=Yii::app()->db->createCommand()
                ->select("pd.id,tp.product_name,pd.qty,pd.price,tp.product_code")
                ->from('tbl_purchasedetail pd')
                ->join('tb_product tp','pd.Item_id=tp.product_id')
                ->where('pd.PurchaseOrder_id=:id',array(':id'=>$poid))
                ->queryAll(); 

     $i=0;
    foreach($purchasedetails as $d)
    {
         $i++;
        echo "<tr>\n";
        echo "<td align='center'>".$i."<input type='hidden' name='pids[]' value='".$d["id"]."' id='pid_".$i."'></td>";
        echo "<td align='center'>".$d["product_code"]."</td>";
        echo "<td>".$d["product_name"]."</td>";
        $purchase_qty=$d["qty"];
        

        echo "<td><input type='text' disabled  class='form-control qty' 
                  style='text-align: center; width: 80px' 
                  value='". $purchase_qty ."'
                  id='txtpurchaseqty_".$i."'
                  /></td>\n";

        echo "<td><input type='text' disabled  class='form-control price' 
                      style='text-align: right; width: 100px' 
                      value='".$purchase_qty."'
                      id='txtreceive_qty_".$i."'
                      /></td>\n";

        echo "<td>&nbsp;</td>";

      
         echo "</tr>\n";
        echo "</tr>";   
    }
    
  }

  public function actionGenProductCode() {
    $varTime = microtime();
    $varTime = str_replace(" ", "", $varTime);
    $varTime = str_replace(".", "", $varTime);

    echo $varTime;
  }

  public function actionSaveProduct() {
    if (!empty($_POST)) {
      $model = new Product();
      $model->attributes = $_POST["Product"];

      if ($model->save()) {
        echo "success";
      }
    }
  }

  public function actionGetProductInfo($product_code) {
    $condition = array();
    $condition["product_code"] = $product_code;

    $model = Product::model()->findByAttributes($condition);
    echo CJSON::encode($model);
  }

  public function actionPrintBarCode($barcode = null) 
  {
    $barcode = new Barcode39($barcode);
    $barcode->draw();
  }


  public function actionModifyReceivedTransaction()
  {
     $rid = Yii::app()->request->getParam('rid');
     $qty = Yii::app()->request->getParam('qty');
     $receive_id=0;
     {
        $model=Receivetransaction::model()->findByPk($rid);
        $receive_id= $model->PODetail_id;
        $model->receive_qty=$qty;
        if($model->purchase_qty==$qty)
          $model->status=1;
        $model->update();
     }

     $modelReceived=Received::model()->findByPk($receive_id);
     $po_id= $modelReceived->po_id;

     $criteria=new CDbCriteria();
     $criteria->select ="id";
     $criteria->condition="receive_id=:receive_id and receive_qty<purchase_qty ";
     $criteria->params=array(":receive_id"=>$rid);
     $modelReceivedDetail=Receivetransaction::model()->findAll($criteria);

     


  }

  public function actionModifyPurchaseDetail()
  {
     $pids = Yii::app()->request->getParam('pids');
     $prices = Yii::app()->request->getParam('prices');
     $qtys = Yii::app()->request->getParam('qtys');
     {
        $model=Purchasedetail::model()->findByPk($pids);
        $model->price=$prices;
        $model->qty=$qtys;
        $model->update();
    }
  }

  public function actionModifyShipingDetail()
  {
     $pids = Yii::app()->request->getParam('pids');
     $prices = Yii::app()->request->getParam('prices');
     $qtys = Yii::app()->request->getParam('qtys');
     {
        $model=Shipingdetail::model()->findByPk($pids);
        $model->price=$prices;
        $model->qty=$qtys;

        $model->update();
    }
  }

  public function actionSaleSaveOnGrid() {
    $billSaleDetail = Yii::app()->session['billSaleDetail'];

    $prices = $_POST['prices'];
    $qtys = $_POST['qtys'];
    $serials = $_POST['serials'];

    // remove product item from array
    for ($i = 0; $i < count($billSaleDetail); $i++) {
      $product_code = $billSaleDetail[$i]['product_code'];

      $product = Product::model()->findByAttributes(array(
          'product_code' => $product_code
      ));

      $billSaleDetail[$i]['product_serial_no'] = $serials[$i];
      $billSaleDetail[$i]['product_price'] = $prices[$i];
      $billSaleDetail[$i]['product_qty'] = $qtys[$i];

      if ($prices[$i] < $product->product_price) {
        $billSaleDetail[$i]['has_bonus'] = 'yes';
      } else {
        $billSaleDetail[$i]['has_bonus'] = 'no';
      }
    }

    Yii::app()->session['billSaleDetail'] = $billSaleDetail;
  }

}


