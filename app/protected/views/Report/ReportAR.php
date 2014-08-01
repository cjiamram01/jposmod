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
    <div class="panel-heading">รายงานลูกหนี้</div>

    <div class="panel-body">
        <?php
        $model = new BillSale();
        
        $criteria = new CDbCriteria();
        $criteria->select = 't.bill_sale_id, t.member_id, member_name, member_tel, member_address';
        $criteria->join = ' INNER JOIN tb_member AS b ON b.member_id = t.member_id ';
        $criteria->condition = 'bill_sale_pay_date IS NULL';
        $criteria->condition = 'bill_sale_drop_bill_date IS NULL';
        $criteria->group = 'b.member_id';
        $criteria->order = 'b.member_id ASC';
        
        $dataProvider = new CActiveDataProvider($model, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 25)
        ));
        
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $dataProvider,
            'summaryText' => "แสดงข้อมูลตั้งแต่ {start} ถึง {end} จากข้อมูล {count}",
            'pager' => array('header' => ''),
            'columns' => array(
                array(
                    'name' => 'member.member_name',
                    'htmlOptions' => array(
                        'width' => '100'
                    ),
                ),
                array(
                    'name' => 'member.member_tel',
                    'htmlOptions' => array(
                        'width' => '50',
                        'style' => 'text-align: center',
                    ),
                ),
                array(
                    'name' => 'member.member_address',
                    'htmlOptions' => array(
                        'width' => '200',
                        'style' => 'text-align: left; padding-left: 30px;',
                    ),
                ),
                array(
                    'header' => 'หนี้รวม',
                    'value' => array($model, "getSumReport"),
                    'htmlOptions' => array(
                        'width' => '100',
                        'style' => 'text-align: right; padding-right: 1%;',
                    ),
                ),
            ),
        ));
        ?>
    </div>
</div>