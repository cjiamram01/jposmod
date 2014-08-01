<script type="text/javascript">
    $(function() {
        $("#BillImportDetail_product_id").keyup(function(e) {
            if (e.keyCode == 13) {
                showProductName();
            }
        });
    });
    
    function showProductName() {
        var product_code = $("#BillImportDetail_product_id").val();
        
        $.ajax({
           url: 'index.php?r=Ajax/getProductInfo',
           dataType: 'json',
           data: {
               product_code: product_code
           },
           success: function(data) {
               $("#lblProductName").val(data.product_name);
               $("#BillImportDetail_import_bill_detail_price").focus();
           }
        });
    }
</script>

<div class="panel panel-primary" style="margin: 10px">
    <div class="panel-heading">
			รับเข้าสินค้าในบิล : 
			<?php echo $modelBillImport->bill_import_code; ?>
		</div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'focus' => array($model, 'product_id'),
            'htmlOptions' => array(
                'name' => 'form1'
                )));
        echo $form->errorSummary($model);
        ?>
				
        <div>
            <?php echo $form->labelEx($model, 'product_id'); ?>
            <?php echo $form->textField($model, 'product_id', array(
                'value' => @$model->product->product_code,
								'class' => 'form-control',
								'style' => 'width: 200px'
            )); ?>
            <a href="#" class="btn btn-primary" onclick="showProductName()">
                <i class="glyphicon glyphicon-search"></i>
                แสดงข้อมูล
            </a>
        </div>
				
        <div>
            <label></label>
            <?php echo $form->textField($model, 'product_id', array(
                'disabled' => 'disabled',
                'id' => 'lblProductName',
                'class' => 'form-control',
								'style' => 'width: 310px',
                'value' => @$model->product->product_name == "" ? "" 
													: $model->product->product_name
            )); ?>
        </div>
				
        <div>
            <?php echo $form->labelEx($model, 'import_bill_detail_product_qty'); ?>
            <?php
            echo $form->textField($model, 'import_bill_detail_product_qty', array(
                'class' => 'form-control',
								'style' => 'width: 100px',
                'value' => @$model->import_bill_detail_product_qty == "" ? 1 
													: $model->import_bill_detail_product_qty
            ));
            echo CHtml::hiddenField('qty_before', @$model->import_bill_detail_product_qty);
            ?>
        </div>
				
        <div>
            <?php echo $form->labelEx($model, 'import_bill_detail_price'); ?>
            <?php echo $form->textField($model, 'import_bill_detail_price', array(
							'class' => 'form-control',
							'style' => 'width: 100px'
						)); ?>
            <span style="color: red">* ถ้าไม่ป้อน จะยึดตามราคาสินค้าที่ตั้งไว้</span>
        </div>
				
        <div class="buttons">
            <?php echo $form->hiddenField($model, 'bill_import_detail_id'); ?>
            <?php echo $form->hiddenField($model, 'bill_import_code'); ?>
						
						<label></label>
            <a href="#" onclick="document.form1.submit()" class="btn btn-primary">
							<b class="glyphicon glyphicon-floppy-disk"></b>
							บันทึกรายการ
						</a>
        </div>
				
        <?php $this->endWidget(); ?>

        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $model->search($modelBillImport->bill_import_code),
            'columns' => array(
                'bill_import_detail_id',
                'product.product_code',
                'product.product_name',
                'import_bill_detail_product_qty',
                'import_bill_detail_price',
                'product.product_total_per_pack',
                'import_bill_detail_qty',
                'product.product_quantity',
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{edit} {del}',
                    'buttons' => array(
                        'edit' => array(
                            'label' => '
															<span class="btn btn-success">
																<b class="glyphicon glyphicon-pencil"></b>
															</span>',
                            'url' => 'Yii::app()->createUrl("Basic/BillImportDetail", array(
															"id" => $data->bill_import_detail_id, 
															"bill_import_code" => $data->bill_import_code
														))'
                        ),
                        'del' => array(
                            'label' => '
															<span class="btn btn-danger">
																<b class="glyphicon glyphicon-trash"></b>
															</span>
														',
                            'url' => 'Yii::app()->createUrl("Basic/BillImportDetailDelete", array(
															"id" => $data->bill_import_detail_id, 
															"bill_import_code" => $data->bill_import_code
														))',
                            'options' => array(
                                'onclick' => 'return confirm("ยืนยันการลบ")'
                            )
                        )
                    ),
                    'htmlOptions' => array(
                        'width' => '100px',
                        'align' => 'center'
                    )
                )
            )
        ));
        ?>
    </div>
</div>

