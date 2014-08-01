<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">
    body, table {
        font-family: Tahoma;
        font-size: 15px;
    }
    table {
        border-collapse: collapse;
    }
    table tr th, td {
        border: #999 solid 1px;
        padding: 5px;
    }
    table tr th{
        background-color: #ddd;
    }
</style>

<div class="panel panel-primary" style="margin: 10px">
    <div class="panel-heading">รายงานสินค้า</div>

    <div class="panel-body">
        <?php
        $model = new Product();
        
        $dataProvider = new CActiveDataProvider($model, array(
            'pagination' => array('pageSize' => 50)
        ));
        
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $dataProvider,
            'summaryText' => "แสดงข้อมูลตั้งแต่ {start} ถึง {end} จากข้อมูล {count}",
            'pager' => array('header' => ''),
            'columns' => array(
                array(
                    'name' => 'product_code',
                    'htmlOptions' => array(
                        'width' => '100',
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'name' => 'product_name',
                    'htmlOptions' => array(
                        'width' => '450',
                        'style' => 'text-align: left; padding-left: 30px;',
                    ),
                ),
                array(
                    'name' => 'product_quantity',
                    'htmlOptions' => array(
                        'width' => '100',
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'name' => 'product_total_per_pack',
                    'htmlOptions' => array(
                        'width' => '100',
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'name' => 'product_quantity_of_pack',
                    'htmlOptions' => array(
                        'width' => '140',
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'name' => 'product_price',
                    'htmlOptions' => array(
                        'width' => '80',
                        'style' => 'text-align: center; background-color: #ffffcc;',
                    ),
                ),
                array(
                    'name' => 'product_price_send',
                    'htmlOptions' => array(
                        'width' => '80',
                        'style' => 'text-align: center;',
                    ),
                ),
            ),
        ));
        ?>
    </div>
</div>