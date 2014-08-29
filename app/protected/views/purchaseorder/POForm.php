<style>
  #textSum {
    background-color: #808080; 
    color: greenyellow; 
    font-size: 25px; 
    font-weight: bold; 
    border: #000000 1px solid; 
    text-align: right; 
    padding-right: 5px;
    padding-top: 2px;
    padding-bottom: 2px;
    display: inline-block;
    width: 150px;
  }

  .mynav {
    border-bottom: #cccccc 1px solid;
    padding: 0px;
    display: inline-block;
    width: 100%;
    background: #f2f5f6;
  }

  .mynav ul li a {
    padding: 10px;
  }

  .mynav ul li {
    padding: 0px;
  }
</style>

<script type="text/javascript">
<?php $strPath= Yii::app()->baseUrl; ?>
  function computePrice(i) 
  {
    var pid=document.getElementById('pid_'+i).value;
    var qty=document.getElementById('txtQty_'+i).value;
    var price=document.getElementById('txtPrice_'+i).value;
    var output =document.getElementById('txtTotalPrice_' + i);
  
    output.value=numeral(price * qty).format('0, 0');
    saveList(pid,price,qty) ;
    computeTotal();
  }

function saveList(pid,price,qty)
      {
        var URL = '<?php echo $strPath; ?>/ModifyPurchaseDetail.php?pids='+pid+'&prices='+price+'&qtys='+qty;

        if (window.XMLHttpRequest)
        {req=new XMLHttpRequest();}
        else if (window.ActiveXObject)
        {req=new ActiveXObject("Microsoft.XMLHTTP");}
        else
        {return false;}
        
        req.onreadystatechange = statechange;
        req.open("GET",URL,true);
        req.send(null);
      }
      function statechange()
      {
        if (req.readyState==4) {
        }
        else{
        }
      } 


function computeTotal()
{
   sum=0;
   i=0;
   $("table.items tbody tr").each(function(data) 
    {
      var tr = $(this);
      // ผลรวมของ จำนวน
      tr.find("input.total").each(function(data) 
      {    
        i++;
        sum += Number(document.getElementById("txtTotalPrice_"+i).value.replace(",",""));
      });
    });
   document.getElementById("txtTotal").value=numeral(sum).format('0, 0');;
}




  function saveList(pid,price,qty)
      {
        var URL = '<?php echo $strPath; ?>/ModifyPurchaseDetail.php?pids='+pid+'&prices='+price+'&qtys='+qty;

        if (window.XMLHttpRequest)
        {req=new XMLHttpRequest();}
        else if (window.ActiveXObject)
        {req=new ActiveXObject("Microsoft.XMLHTTP");}
        else
        {return false;}
        
        req.onreadystatechange = statechange;
        req.open("GET",URL,true);
        req.send(null);
      }
      function statechange()
      {
        if (req.readyState==4) {
        }
        else{
        }
      } 



  function saveModifyPurchaseDetail(pid,price,qty) 
  {
   var formData = $("#formGrid").serializeArray();
   var URL = '<?php echo $strPath; ?>/ModifyPurchaseDetail.php?pid='+pid+'&price='+price+'&qty='+qty;
  }


  function browseSupplier() 
  {
    var uri = "<?php echo $strPath; ?>/Dialog/DialogSupplier";
    var options = "dialogWidth=750px; dialogHeight=400px";
    var w = window.showModalDialog(uri, null, options);
    if (w != null) 
    {
      $("input[id=supplier_name]").val(w.supplier_name);
      $("input[id=hdnSuppId]").val(w.supplier_id);
    }
  }

   function poReset() 
   {
    if (confirm('ทำการสั่งซื้อใหม่?')) 
    {
      window.location='<?php echo $strPath; ?>/Basic/PO';
    }
   }


   function poModify() 
   {
        var uri = "<?php echo $strPath; ?>/Dialog/DialogSearchPO";
        var options = "dialogWidth=750px; dialogHeight=400px";
        var w = window.showModalDialog(uri, null, options);
   }

  function modifyPO(id)
  {

        var uri = "<?php echo $strPath; ?>/basic/PO/"+id;
        window.location=uri;
  }

   window.onload = function() {
   // $("input[name=product_code]").focus();
   computeTotal();
  }



$(function() {
  $("#search").autocomplete(
  {
      source:'<?php echo $strPath; ?>/GetProductJson.php',
      minLength: 2,
      select: function( event, ui )
      {$("input[id=product_id]").val(ui.item.id);}
  })

});
  </script>

<div class="panel panel-primary" style="margin: 10px">
  <div class="panel-heading">ระบบออกใบสั่งซื้อสินค้า</div>

 <div class="navbar-primary mynav">
    <ul class="nav navbar-nav">
       <li>
        <a href="#" onclick="poReset()">
          <i class="glyphicon glyphicon-refresh"></i>
          ทำการสั่งซื้อใหม่
        </a>
      </li>
     </ul>
     <ul class="nav navbar-nav">
       <li>
        <a href="#" onclick="poModify()">
          <i class="glyphicon glyphicon-cog"></i>
          แก้ไขการสั่งซื้อ
        </a>
      </li>
     </ul>
  </div>

   <div class="panel-body">
   	 <?php
    $form = $this->beginWidget('CActiveForm', array(
        'htmlOptions' => array(
            'name' => 'formPO',
            'id' => 'formPO'
        )
    ));

    $form->errorSummary($model);
    ?>

     <table width="100%">
      <tr>
       <td>
       	<div class="form-group">

		<?php echo $form->labelEx($model,'supplier_id',array('class'=>'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
     
       <?php
                    $id= Yii::app()->request->getParam('id');
                    $po_no="";
                    $quotation_no="";
                    $order_date;
                    if(isset($id))
                    {
                      $model=Purchaseorder::model()->findByPk($id);
                      $po_no=$model->po_no;
                      $quotation_no=$model->quotation_no;
                      $order_date=$model->order_date;
                      $supplier= $model->getSupplier($id);
                    }
            ?>

      <input type='hidden' id='hdnSuppId' value="<?php
            if(isset($supplier))
            {
              echo $supplier['farmer_id'];
            }
          ?>"
       name='hdnSuppId'>
             <input type="text" 
               id="supplier_name" 
               name="supplier_name" 
               value="<?php
                if(isset($supplier))
                  echo $supplier['farmer_name'];
              ?>" 
               disabled="disabled" 
               class="form-control"
               style="width: 300px" />
          <a href="#" onclick="browseSupplier()" class="btn btn-primary">
          <i class="glyphicon glyphicon-search"></i>
          ...</a>
         </div>
		<div class="form-group">
          	<?php echo $form->labelEx($model,'po_no',array('class'=>'col-sm-2 control-label')); ?>
          	<div class="col-sm-2">
          				<?php echo $form->textField($model,'po_no',array('maxlength'=>20,'class'=>'form-control','style'=>'width: 300px' ,'value'=> $po_no)); ?>
            </div>
            <?php echo $form->labelEx($model,'quotation_no',array('class'=>'col-sm-2 control-label')); ?>

              <div class="col-sm-2">
                  <?php echo $form->textField($model,'quotation_no',array('maxlength'=>20,'class'=>'form-control','style'=>'width: 300px','value'=>$quotation_no)); ?>
            </div>
  	 		<?php echo $form->labelEx($model,'order_date',array('class'=>'col-sm-2 control-label')); ?>
  	 		<div class="col-sm-2">
  	 			 <input type="text" name="order_date" class="form-control calendar" 

              value="<?php 
                if(isset($supplier))
                  echo date("d/m/Y", strtotime($order_date));
                else
                  echo date("d/m/Y");

              ?>"

               style="width: 120px" />
               <?php if(!isset($supplier)): ?>  
                 <a href="#" class="btn btn-primary" onclick="document.formPO.submit()">
                 <i class="glyphicon glyphicon-floppy-disk"></i>
                บันทึก
              </a>
                <?php endif; ?> 
  	 		</div>
        <div class="col-sm-2">
             
        </div>
          </div>
		</div>

       </td>

      </tr>
  </table>

        <?php $this->endWidget(); ?>

   </div>


</div>

<?php $this->renderPartial('//purchasedetail/formPurchaseDetail',array('modelDetail'=>$modelDetail)); ?>
