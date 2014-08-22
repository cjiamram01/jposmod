<?php
/* @var $this PurchasedetailController */
/* @var $model Purchasedetail */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'purchasedetail-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
		<?php echo $form->error($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'PurchaseOrder_id'); ?>
		<?php echo $form->textField($model,'PurchaseOrder_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'PurchaseOrder_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Item_id'); ?>
		<?php echo $form->textField($model,'Item_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'Item_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty'); ?>
		<?php echo $form->textField($model,'qty',array('size'=>18,'maxlength'=>18)); ?>
		<?php echo $form->error($model,'qty'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->