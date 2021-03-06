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


function PopupCenter(url, title, w, h) 
  {
    // Fixes dual-screen position                         Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

    width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'directories=0,titlebar=0,addressbar=0,scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow
        if (window.focus) 
        {
            newWindow.focus();
        }
   }

function browseCustomer() 
{
    var uri = "<?php echo $strPath; ?>/Dialog/DialogCustomer";
    PopupCenter(uri,"Browse Customer.",800,600);
  
  }

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
    var URL = '<?php echo $strPath; ?>/ModifyShipingDetail.php?pids='+pid+'&prices='+price+'&qtys='+qty;

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


   window.onload = function() {
   computeTotal();
  }


   function shipingBrows() 
   {
        var uri = "<?php echo $strPath; ?>/Dialog/DialogSearchShiping";
        PopupCenter(uri,"Browse Shiping.",750,400);

   }

  function modifyShiping(id)
  {
        var uri = "<?php echo $strPath; ?>/Shiping/Ship/"+id;
        window.location=uri;
  }



$(function() {
  $("#Shiping_customer").autocomplete(
  {
      source:'<?php echo $strPath; ?>/GetCustomer.php',
      minLength: 2,
      select: function( event, ui )
      {
      	//$("input[id=product_id]").val(ui.item.id);

      }
  })

});

 function shipingReset() 
   {
    if (confirm('ทำการส่งสินค้่าใหม่?')) 
    {
      window.location='<?php echo $strPath; ?>/Shiping/Ship';
    }
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
<div class="panel-heading">ระบบส่งสินค้าให้ลูกค้า</div>

 <div class="navbar-primary mynav">
    <ul class="nav navbar-nav">
       <li>
        <a href="#" onclick="shipingReset()">
          <i class="glyphicon glyphicon-refresh"></i>
          ทำการส่งสินค้าใหม่
        </a>
      </li>
     </ul>
     <ul class="nav navbar-nav">
       <li>
        <a href="#" onclick="shipingBrows()">
          <i class="glyphicon glyphicon-cog"></i>
          แก้ไขการส่งสินค้า
        </a>
      </li>
     </ul>
  </div>

   <div class="panel-body">


   	 <?php
    $form = $this->beginWidget('CActiveForm', array(
        'htmlOptions' => array(
            'name' => 'formShiping',
            'id' => 'formShiping',
            'enctype' => 'multipart/form-data',
        )
    ));

    $form->errorSummary($model);
    ?>

	<table width="100%">
	<tr>
	<td>
		<div class="row">
			<?php echo $form->labelEx($model,'customer',array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-4">
				<?php echo $form->textField($model,'customer',array('size'=>60,'maxlength'=>400,'class'=>'form-control')); ?>
			  <input type='hidden' name='customer_code' id='customer_code'> 
      </div>
			<div class="col-sm-1">
				 <a href="#" onclick="browseCustomer()" class="btn btn-primary">
          		<i class="glyphicon glyphicon-search"></i>...</a>
			</div>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'shiping_date',array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-2">
				<?php $currdate=date("d/m/Y"); ?>
				<?php echo $form->textField($model,'shiping_date',array('value'=>$currdate,'class'=>'form-control calendar')); ?>
			</div>
			<?php echo $form->labelEx($model,'car_code',array('class'=>'col-sm-1 control-label')); ?>
			<div class="col-sm-3">
				<?php echo $form->textField($model,'car_code',array('size'=>60,'maxlength'=>20,'class'=>'form-control')); ?>
			</div>
      <?php echo $form->labelEx($model,'bill_no',array('class'=>'col-sm-1 control-label')); ?>
      <div class="col-sm-2">
        <?php echo $form->textField($model,'bill_no',array('size'=>60,'maxlength'=>20,'class'=>'form-control')); ?>
      </div>
		</div>

		
		<div class="row">
			<?php echo $form->labelEx($model,'detail',array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-9">
				<?php echo $form->textField($model,'detail',array('size'=>60,'maxlength'=>20,'class'=>'form-control')); ?>
			</div>
		</div>


		<div class="row">
			<?php echo $form->labelEx($model,'picture',array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-4">
				<?php
		      echo $form->fileField($model, 'picture', array(
		          'class' => 'form-control',
		          'style' => 'width: 470px; display: inline-block;'
		      ));
		      ?>
			</div>
			<div class="col-sm-1">
				
        <?php $id= Yii::app()->request->getParam('id'); ?>
         <?php if(!isset($id)): ?> 

        <a href="#" class="btn btn-primary" onclick="document.formShiping.submit()">
                 <i class="glyphicon glyphicon-floppy-disk"></i>
                บันทึก
              	</a>
           <?php endif; ?> 
			</div>
		</div>
	</td>
	</tr>
	</table>

    <?php $this->endWidget(); ?>


</div>

</div>
<?php $this->renderPartial('//shipingdetail/formShipingDetail'); ?>

