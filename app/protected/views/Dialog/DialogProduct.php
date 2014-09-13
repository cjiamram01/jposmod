<script type="text/javascript">
    function chooseProduct(product_code) {
        //window.returnValue = product_code;
        window.opener.product_code.value=product_code;
        window.opener.saleSubmit();
        window.close();
    }
</script>

<div class="alert alert-danger">
    * เลือกรายการสินค้าที่ต้องการ
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model,
    'columns' => array(
        array(
            'name' => 'product_code',
            'type' => 'raw',
            'value' => '
							CHtml::link(
								$data->product_code, 
								"#", 
								array(
									"onclick" => "chooseProduct(\'$data->product_code\')"
								)
							)
						',
            'htmlOptions' => array(
                'align' => 'center',
                'width' => '100px'
            )
        ),
        'product_name',
        'product_price',
        'product_price_send'
    )
));
?>
    