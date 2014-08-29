<script type="text/javascript">
  function chooseRecord(customer_code, customer_name) {
    var cust = {
      customer_code: customer_code,
      Shiping_customer: customer_name
    };

    window.returnValue = cust;
    window.close();
  }
</script>

<div class="panel panel-primary">
  <div class="panel-heading">เลือกลูกค้า</div>
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
                'name' => 'member_code',
                'type' => 'raw',
                'value' => 'CHtml::link($data->member_code, "#", array(
							"onclick" => "chooseRecord(\'$data->member_code\', \'$data->member_name\')"
						))',
                'htmlOptions' => array(
                    'align' => 'center',
                    'width' => '100px'
                )
            ),
            'member_name',
            'member_tel',
            'member_address'
        )
    ));
    ?>
  </div>
</div>

