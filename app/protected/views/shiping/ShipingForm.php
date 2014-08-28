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


<div class="panel panel-primary" style="margin: 10px">
<div class="panel-heading">ระบบส่งสินค้าให้ลูกค้า</div>


   <div class="panel-body">


   	 <?php
    $form = $this->beginWidget('CActiveForm', array(
        'htmlOptions' => array(
            'name' => 'formShiping',
            'id' => 'formShiping'
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
			</div>
			<div class="col-sm-1">
				 <a href="#" onclick="" class="btn btn-primary">
          		<i class="glyphicon glyphicon-search"></i>...</a>
			</div>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'shiping_date',array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-2">
				<input type="text" name="shiping_date" class="form-control calendar" >
			</div>
			<?php echo $form->labelEx($model,'car_code',array('class'=>'col-sm-1 control-label')); ?>
			<div class="col-sm-5">
				<?php echo $form->textField($model,'car_code',array('size'=>60,'maxlength'=>20,'class'=>'form-control')); ?>
			</div>
		</div>

		
		<div class="row">
			<?php echo $form->labelEx($model,'detail',array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-8">
				<?php echo $form->textField($model,'detail',array('size'=>60,'maxlength'=>20,'class'=>'form-control')); ?>
			</div>
		</div>


		<div class="row">
			<?php echo $form->labelEx($model,'picture',array('class'=>'col-sm-2 control-label')); ?>
			<div class="col-sm-5">

				<?php
		      echo $form->fileField($model, 'picture', array(
		          'class' => 'form-control',
		          'style' => 'width: 470px; display: inline-block;'
		      ));
		      ?>
				

			</div>
		</div>
	</td>
	</tr>
	</table>

    <?php $this->endWidget(); ?>


</div>

</div>
