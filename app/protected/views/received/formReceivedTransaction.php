
<?php $strPath= Yii::app()->baseUrl; ?>
<script type="text/javascript">

</script>

<div class="panel panel-primary" style="margin: 10px">
<div class="panel-body">
<form id="formGrid">
      <div class="" style="background-color: white;">
        <table class="table table-bordered table-striped items" width="100%">
          <thead style="background: #7FA2CA;color: #FFFFFF;">

            <tr>
              <th width="30px" align="center">ลำดับ</th>
              <th width="100px" align="center">รหัสสินค้า</th>
              
              <th align="center">ชื่อรายการ</th>
              <th width="100px" align="center">จำนวนซื้อ</th>
              <th width="100px" align="center">จำนวนรับ</th>
            
              <th width="30px" align="center"></th>
            </tr>

          </thead>
          <tbody>
          
            <?php

              $receive_id= Yii::app()->request->getParam('receive_id');
              if(isset($receive_id))
              {
                 $details=Yii::app()->db->createCommand()
                 ->select("tr.id,tp.product_name,tr.purchase_qty,tr.receive_qty,tp.product_code")
                 ->from('tbl_receivetransaction tr')
                 ->join('tb_product tp','tr.item_id=tp.product_id')
                 ->where('tr.received_id=:id',array(':id'=>$receive_id))
                 ->queryAll(); 
                 $i=0;
                foreach($details as $d)
                {
                  
                  $i++;
                  echo "<tr>\n";
                  echo "<td align='center'>".$i."<input type='hidden' name='pids[]' value='".$d["id"]."' id='pid_".$i."'></td>";
                  echo "<td align='center'>".$d["product_code"]."</td>";
                  echo "<td>".$d["product_name"]."</td>";
                  $purchase_qty=$d["purchase_qty"];
                  $receive_qty=$d["receive_qty"];
                  $rid=$d["id"];


                  echo "<td><input type='text'  class='form-control qty' 
                      style='text-align: center; width: 80px' 
                      value='". $purchase_qty ."'
                      id='txtpurchase_qty".$i."'
                      /></td>\n";
                  echo "<td><input type='text' onblur='modifyReceivedTransaction(".$rid.",".$i.");'  class='form-control price' 
                      style='text-align: right; width: 100px' 
                      value='".$receive_qty."'
                      id='txtreceive_qty".$i."'
                      /></td>\n";
                  echo "<td>
                    <a href='".$strPath."/basic/ReceiveTransactionDelete/".$d["id"]."?receive_id=".$receive_id."'
                      class='btn btn-danger'>
                      <b class='glyphicon glyphicon-remove'></b>
                    </a></td>";  
                  echo "</tr>\n";
                
                }
              }
             
            ?>
          </tbody>

        </table>
      </form>
    <!--<div style="padding-top: 0px">
      <label style="display: inline-block; text-align: left; width: 50px">
        Total: 
      </label>
       <input id="txtTotal" 
             type="text" 
             class="form-control disabled" 
             disabled="disabled" 
             style="text-align: right; width: 150px" />
      </div>-->
    </div>
  </div> 
</div>
</div>




