<script type="text/javascript">
  function chooseRecord(member_code, member_name) {
    var member = {
      member_code: member_code,
      member_name: member_name
    };

    window.returnValue = member;
    window.close();
  }
</script>

<div class="panel panel-primary">
  <div class="panel-heading">เลือกสมาชิกร้าน</div>
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

