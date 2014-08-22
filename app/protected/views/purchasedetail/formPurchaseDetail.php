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

 <script>


$(function() {
  $( "#search" ).autocomplete(
  {
      source:'../GetProductJson.php',
      minLength: 2,
      select: function( event, ui )
      {$("input[id=product_id]").val(ui.item.id);}
  })

});

</script>
<div class="panel panel-primary" style="margin: 10px">
   <div class="panel-body">


<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'purchasedetail-form',
  'enableAjaxValidation'=>false,
)); ?>

<div style="padding-top: 5px">
<div class="row">
<div class="col-md-1">
   <label style="width: 90px">รายการ:</label>
</div>
<div class="col-sm-3">
 
<input type='hidden' name='product_id' id='product_id'>  
<input type="text" id="search" class="form-control" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">


</div>
<div class="col-md-1">
   <label style="width: 80px">จำนวน:</label>
</div>
<div class="col-sm-1">
  <!--<input type="text" id="qty" value="1" class="form-control" style="width:60px" >-->
    <?php echo $form->textField($modelDetail,'qty',array('size'=>20,'maxlength'=>20,'id'=>'qty','class'=>'form-control')); ?>

</div>
<div class="col-sm-1">
   <label style="width: 50px">ราคา:</label>
</div>
<div class="col-sm-1">
  <!--<input type="text" id="price" value="0" class="form-control" style="width:100px" >-->
  <?php echo $form->textField($modelDetail,'price',array('size'=>20,'maxlength'=>20,'id'=>'price','class'=>'form-control')); ?>
</div>
<div class="col-sm-1">
       <a href="#" class="btn btn-primary" onclick="document.formPO.submit()">
                 <i class="glyphicon glyphicon-floppy-disk"></i>
                เพิ่มรายการ
       </a>
</div>
<div class="col-sm-3">
</div>
<?php $this->endWidget(); ?>



    </div>
  </div>
 




   </div>


    <div class="form-group">


 <form id="formGrid">
      <div class="" style="background-color: white;">
        <table class="table table-bordered table-striped items" width="100%">
          <thead style="background: #7FA2CA;color: #FFFFFF;">

            <tr>
              <th width="30px" >ลำดับ</th>
              <th width="100px">รหัสสินค้า</th>
              
              <th>ชื่อรายการ</th>
              <th width="50px">ราคา</th>
              <th width="50px">จำนวน</th>
       
              <th width="50px">รวม</th>
              <th width="30px"></th>
            </tr>

          </thead>
          <tbody>
          </tbody>
        </table>
      </form>
    </div>

  </div> 





</div>




