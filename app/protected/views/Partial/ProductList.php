<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $model,
    'columns' => array(
       
        'product_code',
        'product_name',
        'product_price',
        'product_cost',
        'product_quantity',
        'product_weight'
    )
));
?>
    