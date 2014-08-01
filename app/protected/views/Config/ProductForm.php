<script type="text/javascript">
  
  function dialogGroupProduct() {
    var url = 'index.php?r=Dialog/DialogGroupProduct';
    var option = 'dialogWidth: 600px; dialogHeight: 500px';

    var w = window.showModalDialog(url, null, option);

    if (w != null) {
      $("#Product_group_product_id").val(w.code);
      $("#Product_group_name").val(w.name);
    }
  }

  function getGroupProductName() {
    var group_product_code = $("#Product_group_product_id").val();

    $.ajax({
      url: 'index.php?r=Ajax/GetGroupProductInfo',
      dataType: 'json',
      cache: false,
      data: {
        group_product_code: group_product_code
      },
      success: function(data) {
        $("#Product_group_name").val(data.group_product_name);
      }
    });
  }

  function genProductCode() {
    $.ajax({
      url: 'index.php?r=Ajax/genProductCode',
      cache: false,
      success: function(data) {
        $("#Product_product_code").val(data);
      }
    });
  }

  function printBarCode() {
    var barcode = $("#Product_product_code").val();
    var url = 'index.php?r=Ajax/PrintBarCode&barcode=' + barcode;
    var $opt = 'dialogWidth: 300; dialogHeight: 100';

    window.showModalDialog(url, null, $opt);
  }
  
  <?php if (!empty($model)): ?>
  $(function() {
    getGroupProductName();
  });  
  <?php endif; ?>
</script>

<div class="panel panel-primary" style="margin: 10px">
  <div class="panel-heading">สินค้า</div>
  <div class="panel-body">
    <?php
    $form = $this->beginWidget("CActiveForm", array(
        'htmlOptions' => array(
            'name' => 'formProduct',
        ),
        'focus' => array($model, 'product_code')
    ));

    echo $form->errorSummary($model);
    ?>
    <div>
      <div class="form-search">
        <?php echo $form->labelEx($model, "product_code"); ?>
        <?php
        echo $form->textField($model, "product_code", array(
            'class' => 'form-control',
            'style' => 'width: 200px'
        ));
        ?>
        <a href="#" class="btn btn-success" title="สร้างรหัสอัตโนมัติ" onclick="genProductCode()">
          <i class="glyphicon glyphicon-export"></i>
          สร้างรหัสบาร์โค้ด
        </a>
        <a href="#" class="btn btn-success" title="พิมพ์บาโค้ด" onclick="printBarCode()">
          <span class="glyphicon glyphicon-barcode"></span>
          พิมพ์บาโค้ด
        </a>
      </div>
    </div>

    <div>
      <?php echo $form->labelEx($model, "product_name"); ?>
      <?php
      echo $form->textField($model, "product_name", array(
          'class' => 'form-control',
          'style' => 'width: 400px'
      ));
      ?>
    </div>

    <div>
      <div class="form-search">
        <?php echo $form->labelEx($model, "group_product_id"); ?>
        <?php
        echo $form->textField($model, "group_product_id", array(
            'class' => 'form-control',
            'style' => 'width: 100px',
            'onblur' => 'getGroupProductName()'
        ));
        ?>
        <?php
        echo $form->textField($model, "group_product_id", array(
            'disabled' => 'disabled',
            'class' => 'form-control',
            'id' => 'Product_group_name',
            'value' => @$model->group_product->group_product_name,
            'style' => 'width: 400px'
        ));
        ?>
        <a href="#" class="btn btn-success" title="ค้นหารายการ" onclick="dialogGroupProduct()">
          <i class="glyphicon glyphicon-search"></i>
          ...
        </a>
      </div>
    </div>
    
    <div>
      <?php echo $form->labelEx($model, 'product_price'); ?>
      <?php
      echo $form->textField($model, 'product_price', array(
          'class' => 'form-control',
          'style' => 'width: 100px'
      ));
      ?>

      <?php echo $form->labelEx($model, 'product_price_send'); ?>
      <?php
      echo $form->textField($model, 'product_price_send', array(
          'class' => 'form-control',
          'style' => 'width: 100px'
      ));
      ?>

      <?php echo $form->labelEx($model, 'product_price_per_pack'); ?>
      <?php
      echo $form->textField($model, 'product_price_per_pack', array(
          'class' => 'form-control',
          'style' => 'width: 100px'
      ));
      ?>
    </div>

    <div>
      <?php echo $form->labelEx($model, 'product_price_buy'); ?>
      <?php
      echo $form->textField($model, 'product_price_buy', array(
          'class' => 'form-control',
          'style' => 'width: 100px'
      ));
      ?>
    </div>

    <div>
      <?php echo $form->labelEx($model, "product_detail"); ?>
      <?php
      echo $form->textField($model, "product_detail", array(
          'class' => 'form-control',
          'style' => 'width: 500px'
      ));
      ?>
    </div>

    <div>
      <?php echo $form->labelEx($model, "product_quantity"); ?>
      <?php
      echo $form->textField($model, "product_quantity", array(
          'class' => 'form-control',
          'style' => 'width: 100px'
      ));
      ?>

      <?php echo $form->labelEx($model, 'product_quantity_of_pack'); ?>
      <?php
      echo $form->textField($model, 'product_quantity_of_pack', array(
          'class' => 'form-control',
          'style' => 'width: 100px'
      ));
      ?>
    </div>

    <div>
      <?php echo $form->labelEx($model, "product_pack_barcode"); ?>
      <?php
      echo $form->textField($model, "product_pack_barcode", array(
          'class' => 'form-control',
          'style' => 'width: 200px'
      ));
      ?>
    </div>
    
    <div>
      <?php echo $form->labelEx($model, "product_total_per_pack"); ?>
      <?php
      echo $form->textField($model, "product_total_per_pack", array(
          'class' => 'form-control',
          'style' => 'width: 100px'
      ));
      ?>

      <?php echo $form->labelEx($model, "product_expire"); ?>
      <span class="alert alert-info" style="padding: 9px;">
        <?php
        echo $form->radioButton($model, "product_expire", array(
            'value' => 'expire',
            'checked' => ($default_product_expire == 'expire')
        ));
        ?> สินค้าไม่สด
        <?php
        echo $form->radioButton($model, "product_expire", array(
            'value' => 'fresh',
            'checked' => ($default_product_expire == 'fresh')
        ));
        ?> สินค้าสด
      </span>

      <?php echo $form->labelEx($model, "product_return"); ?>
      <span class="alert alert-info" style="padding: 9px">
        <?php
        echo $form->radioButton($model, "product_return", array(
            'value' => 'in',
            'checked' => ($default_product_return == 'in')
        ));
        ?> สินค้าของร้าน
        <?php
        echo $form->radioButton($model, "product_return", array(
            'value' => 'out',
            'checked' => ($default_product_return == 'out')
        ));
        ?> สินค้าฝากขาย
      </span>
    </div>
    <div>
      <?php echo $form->labelEx($model, "product_expire_date"); ?>
      <?php
      echo $form->textField($model, "product_expire_date", array(
          'class' => 'form-control calendar',
          'style' => 'width: 100px'
      ));
      ?>

      <?php echo $form->labelEx($model, "product_sale_condition"); ?>
      <span class="alert alert-info" style="padding: 9px">
        <?php
        echo $form->radioButton($model, "product_sale_condition", array(
            'value' => 'sale',
            'checked' => ($default_product_sale_condition == 'sale')
        ));
        ?> ขายได้ทันที
        <?php
        echo $form->radioButton($model, "product_sale_condition", array(
            'value' => 'prompt',
            'checked' => ($default_product_sale_condition == 'prompt')
        ));
        ?> กำหนดจำนวนก่อนทุกครั้ง
      </span>
    </div>

    <div>
      <label></label>
      <a href="#" onclick="formProduct.submit()" class="btn btn-primary">
        <b class="glyphicon glyphicon-floppy-disk"></b>
        Save
      </a>
    </div>
    <?php echo $form->hiddenField($model, "product_id"); ?>
    <?php $this->endWidget(); ?>
  </div>
</div>

