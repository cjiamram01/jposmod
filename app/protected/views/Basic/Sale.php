<style>
  #textSum {
    background-color: #808080; 
    color: greenyellow; 
    font-size: 25px; 
    font-weight: bold; 
    border: #000000 1px solid; 
    text-align: right; 
    padding-right: 5px;
    padding-top: 2px;
    padding-bottom: 2px;
    display: inline-block;
    width: 150px;
  }

  .mynav {
    border-bottom: #cccccc 1px solid;
    padding: 0px;
    display: inline-block;
    width: 100%;
    background: #f2f5f6;
  }

  .mynav ul li a {
    padding: 10px;
  }

  .mynav ul li {
    padding: 0px;
  }
</style>

<script type="text/javascript">
  function browseProduct() {
    var uri = "index.php?r=Dialog/DialogProduct";
    var options = "dialogWidth=800px; dialogHeight=600px";
    var w = window.showModalDialog(uri, null, options);

    if (w != null) {
      $("#product_code").val(w);
      document.formSale.submit();
    }
  }

  function browseMember() {
    var uri = "index.php?r=Dialog/DialogMember";
    var options = "dialogWidth=800px; dialogHeight=600px";
    var w = window.showModalDialog(uri, null, options);

    if (w != null) {
      $("input[name=member_code]").val(w.member_code);
      $("input[name=member_name]").val(w.member_name);
    }
  }

  function endSale() {
    $("#formSale").attr('action', 'index.php?r=Basic/EndSale').submit();
  }

  //Allow for end sale
  function checkAllowEndSale(){
    var flag=false;
    $("table.items tbody tr").each(function(data) 
    {
      var tr = $(this);
      // ผลรวมของ จำนวน
      tr.find("input.qty").each(function(data) 
      {    
        flag=true;
      });
    });

      return flag;

  }

  function dialogEndSale() {
    if(checkAllowEndSale()==true){
    var uri = "index.php?r=Dialog/DialogEndSale";
    var options = "dialogWidth=800px; dialogHeight=420px";
    var w = window.showModalDialog(uri, null, options);

    if (w != null) {
      endSale();
      }
    }
    else
    {
        alert("ชำระเงินเรียบร้อยแล้ว");

    }
  }

  function saleReset() {
    if (confirm('เริ่มการขายใหม่')) {
      $("#formSale").attr('action', 'index.php?r=Basic/SaleReset').submit();
    }
  }

  function printSlip() {
    var uri = "index.php?r=Dialog/DialogPrintSlip";
    var options = "dialogWidth=360px; dialogHeight=550px";
    var w = window.showModalDialog(uri, null, options);
  }

  function printBillSendProduct() {
    //var uri = "index.php?r=Dialog/DialogBillSendProduct";

    var uri="index.php?r=Dialog/DialogReprintBill";
    var options = "dialogWidth=800px; dialogHeight=650px";
    var w = window.showModalDialog(uri, null, options);
  }

  function printBillTax() {
    //var uri = "index.php?r=Dialog/DialogBillAddVat";
    //var options = "dialogWidth=800px; dialogHeight=650px";
    //var w = window.showModalDialog(uri, null, options);
    var uri="index.php?r=Dialog/DialogReprintBillVat";
    var options = "dialogWidth=800px; dialogHeight=650px";
    var w = window.showModalDialog(uri, null, options);
    
  }

  $(function() {
    $("#product_code").blur(function() {
      if ($(this).val().length > 0) {
        document.formSale.submit();
      }
    });
		
		// change color of table
		$(".table").removeClass("table-striped");
		$(".table thead tr th")
			.css("background", "#7FA2CA")
			.css("font-weight", "normal")
			.css("color", "#f9f8f7");
		$(".table tbody tr:odd").css('background', '#cfcfcf');
		$(".table tbody tr:even").css('background-color', '#afafaf');
		
		
  });

  function computePrice(id_price, id_qty, id_output) {
    var output = $("#" + id_output);
    var price = $("#" + id_price);
    var qty = $("#" + id_qty);

    // compute row
    price = Number(price.val());
    qty = Number(qty.val());

    output.text(numeral(price * qty).format('0, 0'));

    // compute sum
    computeSum();

    // save to session
    saveDataOnGrid();
  }

  function computeSum() {
    var lblSumQty = $("#lblSumQty");
    var lblSumPrice = $("#lblSumPrice");
    var sumQty = 0;
    var sumPrice = 0;

    // อ่านค่าแถวทั้งหมดใน Grid
    $("table.items tbody tr").each(function(data) {
      var tr = $(this);

      // ผลรวมของ จำนวน
      tr.find("input.qty").each(function(data) {
        var txtQty = $(this);

        sumQty += Number(txtQty.val());
      });

      // ผลรวมของ ราคา
      tr.find("span.pricePerRow").each(function(data) {
        var txtPricePerRow = $(this);
        var pricePerRow = txtPricePerRow.text();
        var pricePerRow = pricePerRow.replace(",", "");

        sumPrice += Number(pricePerRow);
      });
    });

    var outputSumQty = numeral(sumQty).format('0, 0');
    var outputSumPrice = numeral(sumPrice).format('0, 0');

    // แสดงค่าการคำนวน
    lblSumQty.text(outputSumQty);
    lblSumPrice.text(outputSumPrice);

    // แสดงผลการคำนวน ด้านบนซ้าย
    $("#textSum").text(outputSumPrice);

    // แสดงผลการคำนวน ด้านล่างสุด (ส่วนของการคำนวน ภาษี)
    $("#priceTotal").val(outputSumPrice);

    // คำนวนภาษี
    computeVat();
  }

  function saveDataOnGrid() {
    $.ajax({
      url: 'index.php?r=Ajax/SaleSaveOnGrid',
      type: 'POST',
      data: $("#formGrid").serialize(),
      success: function(data) {
      }
    });
  }

  window.onload = function() {
    $("input[name=product_code]").focus();
  }

  function computeVat() {
    var priceTotal = $("#priceTotal").val().replace(",", "");

    var total = Number(priceTotal);
    var vat = parseFloat(total * 0.07);
    var noVat = parseFloat(total - (vat));

    vat = numeral(vat).format('0, 2');
    noVat = numeral(noVat).format('0, 2');

    $("#priceVat").val(vat);
    $("#priceNoVat").val(noVat);
  }

  function computeNoVat() {
    var total = $("#priceTotal").val();

    $("#priceVat").val(0);
    $("#priceNoVat").val(total);
  }
</script>

<?php $sumTotalPrice = BillSale::sumTotalPrice(); ?>

<div class="panel panel-primary" style="margin: 10px">
  <div class="panel-heading">ขายสินค้าหน้าร้าน</div>

  <div class="navbar-primary mynav">
    <ul class="nav navbar-nav">
      <li>
        <a href="#" onclick="saleReset()">
          <i class="glyphicon glyphicon-refresh"></i>
          เริ่มการขายใหม่
        </a>
      </li>
      <li>
        <a href="#" onclick="dialogEndSale()">
          <i class="glyphicon glyphicon-ok-sign"></i>
          จบการขาย
        </a>
      </li>
      <li>
        <a href="#" onclick="printBillSendProduct()">
          <i class="glyphicon glyphicon-list-alt"></i>
          พิมพ์ใบส่งสินค้า
        </a>
      </li>
      <li>
        <a href="#" onclick="printBillTax()">
          <i class="glyphicon glyphicon-file"></i>
          พิมพ์ใบกำกับภาษี
        </a>
      </li>
      <li>
        <a href="#" onclick="printSlip()">
          <i class="glyphicon glyphicon-sd-video"></i>
          พิมพ์ใบเสร็จ
        </a>
      </li>


    </ul>
  </div>

  <div class="panel-body">

    <!-- form -->
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'htmlOptions' => array(
            'name' => 'formSale',
            'id' => 'formSale'
        )
    ));

    $form->errorSummary($model);
    ?>
    <table width="100%">
      <tr>
        <td>

          <?php
          echo $form->labelEx($model, 'bill_sale_vat', array(
              'style' => 'width: 80px'
          ));
          ?>
          <span class="alert alert-info" style="padding: 8px; display: inline-block">
            <?php
             
               $sessionBillSale = Yii::app()->session['sessionBillSale'];
                
                //echo isset($sessionBillSale['bill_sale_vat'])."xxxxx";

                //die;
                if (!empty($sessionBillSale)) {
                     $billSaleVat=isset($sessionBillSale['bill_sale_vat'])?$sessionBillSale['bill_sale_vat']:"";

                  }

                $radio1 = true;
                $radio2 = false;

                if (!empty($billSaleVat)) 
                {
                if ($billSaleVat == 'no') 
                  {
                      $radio1 = false;
                      $radio2 = true;
                  }
                }


          
            

            ?>

            <?php
            echo CHtml::radioButton('bill_sale_vat', $radio1, array(
                'value' => 'vat',
                'onclick' => 'computeVat()'));
            ?> คิด VAT

            <?php
            echo CHtml::radioButton('bill_sale_vat', $radio2, array(
                'value' => 'no',
                'onclick' => 'computeNoVat()'));
            ?> ไม่คิด VAT
          </span>

          <label style="width: 100px">รูปแบบการขาย</label>
          <span class="alert alert-danger" style="padding: 8px; display: inline-block">
            <?php
            if (!empty($sessionBillSale)) {
              //$saleAuto = $sessionBillSale['sale_auto'];

            }

            $radio1 = true;
            $radio2 = false;

            if (!empty($saleAuto)) {
              if ($saleAuto == 'no_auto') {
                $radio1 = false;
                $radio2 = true;
              }
            }
            ?>
            <?php echo CHtml::radioButton('sale_auto', $radio1, array('value' => 'auto')); ?> 
            ขายอัตโนมัติ

            <?php echo CHtml::radioButton('sale_auto', $radio2, array('value' => 'no_auto')); ?> 
            กำหนดจำนวนก่อน
          </span>

          <label style="width: 100px">การชำระเงิน</label>
          <span class="alert alert-success" style="padding: 8px; display: inline-block">
            <?php
            if (!empty($sessionBillSale)) {
              $saleStatus = isset($sessionBillSale['sale_status'])?$sessionBillSale['sale_status']:"";
            }

            $radio1 = true;
            $radio2 = false;

            if (!empty($saleStatus)) {
              if ($saleStatus == 'credit') {
                $radio1 = false;
                $radio2 = true;
              }
            }
            ?>
            <?php echo CHtml::radioButton('sale_status', $radio1, array('value' => 'cash')); ?> เงินสด
            <?php echo CHtml::radioButton('sale_status', $radio2, array('value' => 'credit')); ?> เงินเชื่อ
          </span>

        </td>

        <td style="vertical-align: top">
          <label style="font-size: 20px; width: 70px">รวม: </label>
          <span id="textSum"><?php echo number_format($sumTotalPrice); ?></span>
        </td>
      </tr>
    </table>

    <div>
      <?php
      if (!empty($sessionBillSale['BillSale'])) {
        $branchId = $sessionBillSale['BillSale']['branch_id'];
        $model['branch_id'] = $branchId;
      }
      ?>
      <?php
      echo $form->labelEx($model, 'branch_id', array(
          'style' => 'width: 80px'
      ));
      ?>
      <?php
      echo $form->dropdownlist($model, 'branch_id', Branch::getOptions(), array(
          'class' => 'form-control',
          'style' => 'width: 200px'
      ));
      ?>

      <?php
      echo $form->labelEx($model, 'bill_sale_created_date', array(
          'style' => 'width: 120px'
      ));
      ?>
      <?php
      echo $form->textField($model, 'bill_sale_created_date', array(
          'value' => date("d/m/Y"),
          'disabled' => 'disabled',
          'class' => 'form-control',
          'style' => 'width: 100px'
      ));

      $member_code = "";
      $member_name = "";

      if (!empty($sessionBillSale['member_code'])) {
        $member_code = $sessionBillSale['member_code'];
      }
      if (!empty($sessionBillSale['member_name'])) {
        $member_name = $sessionBillSale['member_name'];
      }
      ?>

      <label>เงื่อนไขการขาย</label>
      <span class="alert alert-info" style="padding: 8px">
        <input type="radio" name="sale_condition" value="one" checked /> ขายปลีก
        <input type="radio" name="sale_condition" value="many" /> ขายส่ง
      </span>

    </div>

    <div>
      <div class="form-search" style="padding-top: 5px">
        <label style="width: 80px">สมาชิก</label>
        <input type="hidden" name="member_code" value="<?php echo $member_code; ?>" />
        <input type="hidden" name="member_name" value="<?php echo $member_name; ?>" />
        <input type="text" 
               id="member_code" 
               name="member_code" 
               value="<?php echo $member_code; ?>" 
               disabled="disabled"
               class="form-control"
               style="width: 100px" />
        <input type="text" 
               id="member_name" 
               name="member_name" 
               value="<?php echo $member_name; ?>" 
               disabled="disabled" 
               class="form-control"
               style="width: 300px" />
        <a href="#" class="btn btn-primary" onclick="browseMember()">
          <i class="glyphicon glyphicon-search"></i>
          ...
        </a>
      </div>
    </div>

    <div style="padding-top: 5px">
      <div class="form-search">
        <label style="width: 80px">รหัสสินค้า</label>
        <input type="text" 
               name="product_code" 
               id="product_code" 
               class="form-control"
               style="width: 200px"
               />
        <a href="#" class="btn btn-primary" onclick="browseProduct()">
          <i class="glyphicon glyphicon-search"></i>
          ...
        </a>

        <label style="width: 90px">จำนวน</label>
        <input type="text" 
               name="product_qty" 
               value="1" 
               class="form-control"
               style="width: 70px"
               />
        <a href="#" class="btn btn-primary" onclick="document.formSale.submit()">
          <i class="glyphicon glyphicon-floppy-disk"></i>
          บันทึก
        </a>

        <label style="width: 100px">serial code</label>
        <input type="text" name="product_serial_no" class="form-control" 
               style="width: 120px" />
        <label style="width: 120px">วันหมดประกัน</label>
        <input type="text" name="product_expire_date" class="form-control calendar" 
               style="width: 90px" />
      </div>
    </div>
		<?php $this->endWidget(); ?>

    <form id="formGrid">
      <div class="" style="background-color: white;">
        <table class="table table-bordered table-striped items" width="100%">
          <thead style="background: #7FA2CA">

            <tr>
              <th width="30px" >ลำดับ</th>
              <th width="100px">รหัสสินค้า</th>
              <th width="100px">serial no</th>
              <th>ชื่อรายการ</th>
              <th width="50px">ราคา</th>
              <th width="50px">จำนวน</th>
              <th width="150px" style="align:top">จำนวนต่อแพค</th>
              <th width="50px">รวม</th>
              <th width="30px"></th>
            </tr>

          </thead>
          <tbody>

            <?php
            $billSaleDetail = Yii::app()->session['billSaleDetail'];
            $sum_qty = 0;
            $sum_price = 0;
            $sum_qty_per_pack = 0;

            if (!empty($billSaleDetail)):
              $row = 0;
              ?>

              <?php foreach ($billSaleDetail as $r): ?>
                <?php
                $qty = $r['product_qty'];
                $price = $r['product_price'];

                $sum_qty += $qty;
                $sum_price += ($price * $qty);
                $sum_qty_per_pack += $r['product_qty_per_pack'];
                ?>

                <tr style="background: #ffffcc">
                  <td style="text-align: right"><?php echo++$row; ?></td>
                  <td><?php echo $r['product_code']; ?></td>
                  <td>
                    <input 
                      type="text" 
                      class="form-control"
											style="width: 100px" 
                      value="<?php echo $r['product_serial_no']; ?>"
                      id="txtSerialNo_<?php echo $row; ?>"
                      name="serials[]"
                      />
                  </td>
                  <td><?php echo $r['product_name']; ?></td>
                  <td align="right">
                    <input 
                      type="text" 
                      class="form-control price" 
                      style="text-align: right; width: 70px" 
                      value="<?php echo $price; ?>"
                      id="txtPrice_<?php echo $row; ?>"
                      name="prices[]"
                      onkeyup="computePrice(
                				'txtPrice_<?php echo $row; ?>',
                				'txtQty_<?php echo $row; ?>',
                				'lblTotalPricePerRow_<?php echo $row; ?>'
                				)"
                      />
                  </td>
                  <td align="right">
                    <input 
                      type="text" 
                      class="form-control qty" 
                      style="text-align: right; width: 50px" 
                      value="<?php echo $qty; ?>"
                      id="txtQty_<?php echo $row; ?>"
                      name="qtys[]"
                      onkeyup="computePrice(
                				'txtPrice_<?php echo $row; ?>',
                				'txtQty_<?php echo $row; ?>',
                				'lblTotalPricePerRow_<?php echo $row; ?>'
                				)"  
                      />
                  </td>
                  <td align="right">
                    <?php echo number_format($r['product_qty_per_pack']); ?>
                  </td>
                  <td align="right">
                    <span id="lblTotalPricePerRow_<?php echo $row; ?>"
                          class="pricePerRow">
                            <?php echo number_format($qty * $price); ?>
                    </span>
                  </td>
                  <td>
										<a href="index.php?r=Basic/SaleDelete&index=<?php echo $row - 1; ?>"
											class="btn btn-danger">
											<b class="glyphicon glyphicon-remove"></b>
										</a>
                  </td>

                </tr>

              <?php endforeach; ?>
            <?php endif; ?>

          </tbody>
          <tfoot>

            <tr>
              <td>รวม</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>
                <div style="text-align: right" id="lblSumQty">
                  <?php echo number_format($sum_qty); ?>
                </div>
              </td>
              <td>
                <div style="text-align: right">
                  <?php echo number_format($sum_qty_per_pack); ?>
                </div>
              </td>
              <td>
                <div style="text-align: right" id="lblSumPrice">
                  <?php echo number_format($sum_price); ?>
                </div>
              </td>
              <td></td>
            </tr>

          </tfoot>
        </table>
      </div>
    </form>

    <?php
    $priceVat = 0.00;
    $priceNoVat = number_format($sumTotalPrice);
    $priceTotal = number_format($sumTotalPrice);

    if (!empty($billSaleVat)) {
      if ($billSaleVat == 'vat') {
        // VAT
        $priceVat = number_format($sumTotalPrice * .07, 2);
        $priceNoVat = number_format($sumTotalPrice - ($sumTotalPrice * .07), 2);
        $priceTotal = number_format($sumTotalPrice);
      }
    }
    ?>

    <div style="padding-top: 0px">
      <label style="display: inline-block; text-align: left; width: 50px">
        VAT: 
      </label>
      <input id="priceVat" 
             type="text" 
             class="form-control disabled" 
             disabled="disabled" 
             value="<?php echo $priceVat; ?>" 
             style="text-align: right; width: 150px" />

      <label style="display: inline-block; width: 120px; text-align: right">
        ราคาไม่รวม VAT: 
      </label>
      <input id="priceNoVat" 
             type="text" 
             class="form-control disabled" 
             disabled="disabled" 
             value="<?php echo $priceNoVat; ?>" 
             style="text-align: right; width: 150px" />

      <label style="display: inline-block; width: 100px; text-align: right">
        รวมทั้งสิ้น: 
      </label>
      <input id="priceTotal" 
             type="text" 
             class="form-control disabled" 
             disabled="disabled" 
             value="<?php echo $priceTotal; ?>" 
             style="text-align: right; width: 150px" />
    </div>

  </div>		<!-- panel-body -->
</div>			<!-- panel -->



