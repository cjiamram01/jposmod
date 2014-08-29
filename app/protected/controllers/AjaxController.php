<?php

class AjaxController extends Controller {

  public function actionGetGroupProductInfo($group_product_code) {
    $attributes = array();
    $attributes["group_product_code"] = $group_product_code;

    $model = GroupProduct::model()->findByAttributes($attributes);
    echo CJSON::encode($model);
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

  public function actionPrintBarCode($barcode = null) {
    $barcode = new Barcode39($barcode);
    $barcode->draw();
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


