
<?php $strPath= Yii::app()->baseUrl; ?>



 
<div class="panel panel-primary" style="margin: 10px">
   <div class="panel-body">


<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'formPD',
  'enableAjaxValidation'=>false,
)); ?>

<div style="padding-top: 5px">
<div class="row">
<div class="col-md-1">
   <label style="width: 90px">รายการ:</label>
</div>
<div class="col-sm-4">
 
<input type='hidden' name='product_id' id='product_id'>  
<input type="text" id="search" class="form-control" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">


</div>
<div class="col-md-1">
   <label style="width: 80px">จำนวน:</label>
</div>
<div class="col-sm-1">
 <input type="text" id="qty" name="qty" value="1" class="form-control" style="width:60px" >
</div>
<div class="col-sm-1">
   <label style="width: 50px">ราคา:</label>
</div>
<div class="col-sm-1">
  <input type="text" id="price" name="price" value="0" class="form-control" style="width:100px" >
</div>
<div class="col-sm-1">
       <a href="#" class="btn btn-primary" onclick="document.getElementById('formPD').submit();">
                 <i class="glyphicon glyphicon-floppy-disk"></i>
                เพิ่มรายการ
       </a>
</div>

<?php $this->endWidget(); ?>

</div>
</div>
</div>


<div class="panel-body">
<form id="formGrid">
      <div class="" style="background-color: white;">
        <table class="table table-bordered table-striped items" width="100%">
          <thead style="background: #7FA2CA;color: #FFFFFF;">

            <tr>
              <th width="30px" align="center">ลำดับ</th>
              <th width="100px" align="center">รหัสสินค้า</th>
              
              <th align="center">ชื่อรายการ</th>
              <th width="100px" align="center">จำนวน</th>
              <th width="100px" align="center">ราคา</th>
             
       
              <th width="100px" align="center">รวม</th>
              <th width="30px" align="center"></th>
            </tr>

          </thead>
          <tbody>
            <?php
              $id= Yii::app()->request->getParam('id');
              if(isset($id))
              {
                 $details=Yii::app()->db->createCommand()
                ->select("pd.id,tp.product_name,pd.qty,pd.price,tp.product_code")
                ->from('tbl_purchasedetail pd')
                ->join('tb_product tp','pd.Item_id=tp.product_id')
                ->where('pd.PurchaseOrder_id=:id',array(':id'=>$id))
                ->queryAll(); 
                 $i=1;

                foreach($details as $d)
                {
                  echo "<tr>\n";
                  echo "<td align='center'>".$i."<input type='hidden' name='pids[]' value='".$d["id"]."' id='pid_".$i."'></td>";
                  echo "<td align='center'>".$d["product_code"]."</td>";
                  echo "<td>".$d["product_name"]."</td>";
                  $qty=$d["qty"];
                  $price=$d["price"];
                  $total=$d["qty"]*$d["price"];
                  echo "<td><input type='text' onblur=\"computePrice(".$i.")\" class='form-control qty' 
                      style='text-align: center; width: 80px' 
                      value='". $qty ."'
                      id='txtQty_".$i."'
                      /></td>\n";
                  
                  echo "<td><input type='text' onblur=\"computePrice(".$i.")\" class='form-control price' 
                      style='text-align: right; width: 100px' 
                      value='".$price."'
                      id='txtPrice_".$i."'
                      /></td>\n";
                

                  echo "<td align='right'>
                    <input type='text' class='form-control total' 
                      style='text-align: right; width: 100px' 
                      value='". number_format($total) ."'
                      id='txtTotalPrice_".$i."'
                      name='totals[]'
                      disabled=\"disabled\"
                      />

                    </td>\n";

                  

                  echo "<td>
                    <a href='".$strPath."/basic/PurchaseDetailDelete/".$id."?pid=".$d["id"]."'
                      class='btn btn-danger'>
                      <b class='glyphicon glyphicon-remove'></b>
                    </a></td>";  

                  echo "</tr>\n";


                  $i++;
                }
              }
            ?>
          </tbody>

        </table>
      </form>
<div style="padding-top: 0px">
      <label style="display: inline-block; text-align: left; width: 50px">
        Total: 
      </label>
       <input id="txtTotal" 
             type="text" 
             class="form-control disabled" 
             disabled="disabled" 
              
             style="text-align: right; width: 150px" />
</div>

    </div>

  </div> 





</div>




