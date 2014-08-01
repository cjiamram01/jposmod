<script type="text/javascript">
    function showData() {
        $("#form1").submit();
    }
    
    function browseProduct() {
        var uri = "index.php?r=Dialog/DialogProduct";
        var options = "dialogWidth=800px; dialogHeight=600px";
        var w = window.showModalDialog(uri, null, options);
        
        if (w != null) {
            $("#BillSaleDetail_bill_sale_detail_barcode").val(w);
        }
    }
</script>

<div class="panel panel-primary" style="margin: 10px">
    <div class="panel-heading">รับคืนสินค้า</div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'form1',
            'htmlOptions' => array(
                'name' => 'form1'
            )
        ));
        ?>
        <div>
            <?php echo $form->labelEx($model, 'bill_id'); ?>
            <?php echo $form->textField($model, 'bill_id', array(
							'class' => 'form-control',
							'style' => 'width: 200px'
            )); ?>
        </div>
        <div>
            <div class="form-search">
                <?php echo $form->labelEx($model, 'bill_sale_detail_barcode'); ?>
                <?php echo $form->textField($model, 'bill_sale_detail_barcode', array(
									'class' => 'form-control',
									'style' => 'width: 200px'
                )); ?>
								
                <a href="#" class="btn btn-primary" onclick="browseProduct()">
                    <i class="glyphicon glyphicon-search"></i>
                    ...
                </a>
                <a href="#" class="btn btn-success" onclick="showData()">
                    <i class="glyphicon glyphicon-import"></i>
                    แสดงรายการ
                </a>
            </div>
        </div>
        <hr />

        <?php if (!empty($product)): ?>
            <div>
                <?php echo $form->labelEx($product, 'product_code'); ?>
                <?php
                echo $form->textField($product, 'product_code', array(
                    'disabled' => 'disabled',
                    'class' => 'form-control',
										'style' => 'width: 200px'
                ));
                ?>
            
                <?php echo $form->labelEx($product, 'product_pack_barcode'); ?>
                <?php
                echo $form->textField($product, 'product_pack_barcode', array(
                    'disabled' => 'disabled',
                    'class' => 'form-control',
										'style' => 'width: 200px'
                ));
                ?>
            </div>
            <div>
                <?php echo $form->labelEx($product, 'product_name'); ?>
                <?php
                echo $form->textField($product, 'product_name', array(
                    'disabled' => 'disabled',
                    'class' => 'form-control',
										'style' => 'width: 558px'
                ));
                ?>
            </div>
            <div>
                <?php echo $form->labelEx($product, 'group_product_id'); ?>
                <?php
								$group_product = $product->getGroupProductByGroupProductId();
								$group_product_name = '';
								
								if (!empty($group_product)) {
									$group_product_name = $group_product->group_product_name;
								}
								
                echo $form->textField($product, 'group_product_id', array(
                    'disabled' => 'disabled',
                    'class' => 'form-control',
                    'value' => $group_product_name,
										'style' => 'width: 558px'
                ));
                ?>
            </div>
            <div>
                <?php echo $form->labelEx($product, 'product_detail'); ?>
                <?php
                echo $form->textField($product, 'product_detail', array(
                    'disabled' => 'disabled',
                    'class' => 'form-control',
										'style' => 'width: 558px'
                ));
                ?>
            </div>
            <div>
                <?php echo $form->labelEx($product, 'product_created_date'); ?>
                <?php
                echo $form->textField($product, 'product_created_date', array(
                    'disabled' => 'disabled',
                    'class' => 'form-control',
										'style' => 'width: 200px'
                ));
                ?>
            
                <?php echo $form->labelEx($product, 'product_quantity'); ?>
                <?php
                echo $form->textField($product, 'product_quantity', array(
                    'disabled' => 'disabled',
                    'class' => 'form-control',
                    'style' => 'background-color: #ffffcc; color: black; width: 80px'
                ));
                ?>
           
                <?php echo $form->labelEx($product, 'product_total_per_pack'); ?>
                <?php
                echo $form->textField($product, 'product_total_per_pack', array(
                    'disabled' => 'disabled',
                    'class' => 'form-control',
										'style' => 'width: 80px'
                ));
                ?>
            </div>
            <div>
                <?php echo $form->labelEx($product, 'product_expire'); ?>
                <?php
                echo $form->textField($product, 'product_expire', array(
                    'disabled' => 'disabled',
                    'class' => 'form-control',
										'style' => 'width: 200px',
                    'value' => $product->getProductExpire()
                ));
                ?>
            
                <?php echo $form->labelEx($product, 'product_return'); ?>
                <?php
                echo $form->textField($product, 'product_return', array(
                    'disabled' => 'disabled',
                    'class' => 'form-control',
										'style' => 'width: 200px',
                    'value' => $product->getProductReturn()
                ));
                ?>
            </div>
            <div>
                <?php echo $form->labelEx($product, 'product_expire_date'); ?>
                <?php
                echo $form->textField($product, 'product_expire_date', array(
                    'disabled' => 'disabled',
                    'class' => 'form-control',
										'style' => 'width: 200px'
                ));
                ?>
            
                <?php echo $form->labelEx($product, 'product_sale_condition'); ?>
                <?php
                echo $form->textField($product, 'product_sale_condition', array(
                    'disabled' => 'disabled',
                    'class' => 'form-control',
										'style' => 'width: 200px'
                ));
                ?>
            </div>
            <div>
                <?php echo $form->labelEx($product, 'product_price'); ?>
                <?php
                echo $form->textField($product, 'product_price', array(
                    'disabled' => 'disabled',
                    'class' => 'form-control',
										'style' => 'width: 200px'
                ));
                ?>
            
                <?php echo $form->labelEx($product, 'product_price_send'); ?>
                <?php
                echo $form->textField($product, 'product_price_send', array(
                    'disabled' => 'disabled',
                    'class' => 'form-control',
										'style' => 'width: 200px'
                ));
                ?>
            </div>
            <div>
                <label></label>
                <a href="#" class="btn btn-success btn-large" 
									onclick="document.form1.submit()">
                    <i class="glyphicon glyphicon-check"></i>
                    บันทึกรับคืนสินค้า
                </a>
            </div>
            <?php echo CHtml::hiddenField('product_id', $product->product_id); ?>
        <?php endif; ?>
        <?php $this->endWidget(); ?>
    </div>
</div>