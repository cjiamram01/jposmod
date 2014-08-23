<script type="text/javascript">
  function chooseRecord(po_id) {
   /* var supplier = {
      supplier_id: supplier_id,
      supplier_name: supplier_name
    };*/

    var po={
      po_id:po_id
    };

    //window.returnValue = po;
    //window.opener.document.location.href("http://localhost/jpos/app");
    // window.location"http://localhost/jpos/app");
    window.opener.modifyPO(po_id);
    window.close();
   //window.opener.location="http://localhost/jpos/app/basic/PO";
  }
</script>

<div class="panel panel-primary">
  <div class="panel-heading">เลือกผู้จัดจำหน่าย</div>
  <div class="panel-body">
    <form name="formSearch" method="POST">
      <div class="input-group">
        <span>ค้นหา: </span>
        <?php
        echo CHtml::textField('search', @$_POST['search'], array(
            'class' => 'form-control',
            'style' => 'width: 300px; margin-right: 5px'
        ));
        ?>
        <a href="#" onclick="formSearch.submit()" class="btn btn-primary">
          <b class="glyphicon glyphicon-search"></b>
          แสดงรายการ
        </a>
      </div>
    </form>

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $model,
        'columns' => array(
            array(
                'name' => 'po_no',
                'type' => 'raw',
                'value' => 'CHtml::link($data->po_no, "#", array(
							  "onclick" => "chooseRecord(\'$data->id\')"
						))',
                'htmlOptions' => array(
                    'align' => 'center',
                    'width' => '100px'
                )
            ),
            'quotaion_no',
            'Comment',
             array(
                    'name'=>'supplier_id',
                    'value'=>'$data->supplier->farmer_name',
             ),
            //'order_date',
              array(
            'name'=>'order_date',
            'value'=>"Yii::app()->dateFormatter->formatDateTime(\$data->order_date, 'medium', 'short')",
            'filter'=>false, // Set the filter to false when date range searching
        ),

         

            //'farmer_tel',
            //'farmer_address'
        )
    ));
    ?>
  </div>
</div>

