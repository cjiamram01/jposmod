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
  function browseSupplier() {
    var uri = "<?php echo $strPath; ?>/Dialog/DialogSupplier";
    var options = "dialogWidth=750px; dialogHeight=400px";
    var w = window.showModalDialog(uri, null, options);

    if (w != null) {
      //$("input[id=supplier_id]").val(w.supplier_id);
      $("input[id=supplier_name]").val(w.supplier_name);
      $("input[id=hdnSuppId]").val(w.supplier_id);

    }
  }

   function poReset() {
    if (confirm('ทำการสั่งซื้อใหม่?')) {
      $("#formPO").attr('action', '<?php echo $strPath; ?>/Basic/PO').submit();
    }
  }
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
