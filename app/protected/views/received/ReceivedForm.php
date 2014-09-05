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

<script type='text/javascript'>
<?php $strPath= Yii::app()->baseUrl; ?>

function modifyReceivedTransaction(rid,index)
  {
    //var qty=document.getElementById("txtreceive_qty"+index).value;
    var pqty=$("#txtpurchase_qty"+index).val();
    var qty=$("#txtreceive_qty"+index).val();
    if(qty<=pqty)
    {
      var URL = '<?php echo $strPath; ?>/ModifyReceivedTransaction.php?rid='+rid+'&qty='+qty;
      if (window.XMLHttpRequest)
      {req=new XMLHttpRequest();}
      else if (window.ActiveXObject)
      {req=new ActiveXObject("Microsoft.XMLHTTP");}
      else
      {return false;}
      
      req.onreadystatechange = receivetransactionStatechange;
      req.open("GET",URL,true);
      req.send(null);
    }
    else
    {
      $("#txtreceive_qty"+index).val(pqty);
    }

  }
  
  function receivetransactionStatechange()
  {
    if (req.readyState==4) {
    }
    else{
    }
  } 


$(function() {
  $("#Received_po_no").autocomplete(
  {
      source:'<?php echo $strPath; ?>/GetPOJson.php',
      minLength: 2,
      select: function( event, ui )
      {
        $("input[id=po_id]").val(ui.item.id);
        duplicatePO(ui.item.id);
      }
  })

});

function browsePO() 
  {
    var uri = "<?php echo $strPath; ?>/Dialog/DialogBrowsPO";
    var options = "dialogWidth=750px; dialogHeight=400px";
    var w = window.showModalDialog(uri, null, options);
    if (w != null) 
    {
      $("input[id=po_id]").val(w.po_id);
      $("input[id=Received_po_no]").val(w.po_no);
       duplicatePO(w.po_id);
    }
  }



function duplicatePO(poid)
{
  var URL = '<?php echo $strPath; ?>/DuplicatePO.php?pid='+poid;

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
  if (req.readyState==4)
  {
    $("table.items tbody").append(req.responseText);
  }
  else{
  }
} 

function receiveReset()
{
   if (confirm('ทำการสั่งซื้อใหม่?')) 
    {
      window.location='<?php echo $strPath; ?>/Received/receive';
    }
}

 function receiveModify() 
   {
        var uri = "<?php echo $strPath; ?>/Dialog/DialogSearchReceived";
        var options = "dialogWidth=750px; dialogHeight=400px";
        var w = window.showModalDialog(uri, null, options);
   }

 function modifyReceived(id)
  {

        var uri = "<?php echo $strPath; ?>/received/receive?receive_id="+id;
        window.location=uri;
  }


</script>

<div class="panel panel-primary" style="margin: 10px">
  <div class="panel-heading">รับสินค้าเข้าคลัง</div>
     <div class="navbar-primary mynav">
    <ul class="nav navbar-nav">
       <li>
        <a href="#" onclick="receiveReset()">
          <i class="glyphicon glyphicon-refresh"></i>
          รับสินค้าเที่ยวใหม่
        </a>
      </li>
     </ul>
     <ul class="nav navbar-nav">
       <li>
        <a href="#" onclick="receiveModify()">
          <i class="glyphicon glyphicon-cog"></i>
           แก้ไขการรับสินค้า
        </a>
      </li>
     </ul>
  </div>
   <div class="panel-body">
  <?php
    $form = $this->beginWidget('CActiveForm', array(
        'htmlOptions' => array(
            'name' => 'formReceived',
            'id' => 'formReceived',
        )
    ));

    $form->errorSummary($model);
    ?>



      <table width="100%">
      <tr>
       <td>
        <div class="row">
          <?php echo $form->labelEx($model,'po_no',array('class'=>'col-sm-2')); ?>
          <div class="col-sm-2">
          <input type='hidden' id="po_id" name="po_id">
          <?php echo $form->textField($model,'po_no',array('size'=>20,'maxlength'=>20,'class'=>'form-control')); ?>
          </div>
           <div class="col-sm-1">
            <a href="#" onclick="browsePO();" class="btn btn-primary">
                  <i class="glyphicon glyphicon-search"></i>
                  ...</a>
           </div>

           <?php echo $form->labelEx($model,'receive_date',array('class'=>'col-sm-1')); ?>
          <div class="col-sm-2">
              <?php echo $form->textField($model,'receive_date',array('class'=>'form-control calendar','style'=>'width:100px')); ?>
   
          </div>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'transport_supplier',array('class'=>'col-sm-2')); ?>
            <div class="col-sm-3">
            <?php echo $form->textField($model,'transport_supplier',array('class'=>'form-control',)); ?>
 
            </div> 
            <?php echo $form->labelEx($model,'detail',array('class'=>'col-sm-1')); ?>
            <div class="col-sm-4">
             <?php echo $form->textField($model,'detail',array('class'=>'form-control',)); ?>
            </div>
            <div class="col-sm-1">
               <a href="#" class="btn btn-primary" onclick="document.formReceived.submit()">
                 <i class="glyphicon glyphicon-floppy-disk"></i>
                บันทึก
              </a>
            </div>
        </div>
      </td>
      </tr>
    </table>
   
   <?php $this->endWidget(); ?>
   </div>
</div>

<?php $this->renderPartial('//Received/formReceivedTransaction'); ?>
