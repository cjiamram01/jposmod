<script>
  function chooseGroupProduct(code, name) {
    var obj = {
      code: code,
      name: name
    };
    
    window.returnValue = obj;
    window.close();
  }
</script>

<div class="panel panel-primary">
  <div class="panel-heading">ประเภทสินค้า</div>
  <div class="panel-body">
    <table class="table table-striped">
      <thead>
        <tr>
          <th width="50px"></th>
          <th width="100px">รหัสประเภท</th>
          <th width="300px">ชื่อประเภท</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($model as $r): ?>
          <tr>
            <td style="text-align: center">
              <a style="color: white" href="#" 
                 class="btn btn-success" 
                 onclick="chooseGroupProduct(
              '<?php echo $r->group_product_code; ?>',
              '<?php echo $r->group_product_name; ?>'
              )">
                <i class="icon-ok icon-white"></i>
                เลือก
              </a>
            </td>
            <td><?php echo $r->group_product_code; ?></td>
            <td><?php echo $r->group_product_name; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

