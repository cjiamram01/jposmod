<?php if (Yii::app()->request->cookies['user_id'] != null): ?>
<div class="navbar navbar-default">
  <ul class="nav navbar-nav">
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        บันทึกประจำวัน<b class="caret"></b>
      </a>
      <ul class="dropdown-menu">

        <?php $strPath= Yii::app()->baseUrl; ?>
        <li><a href="<?php echo $strPath; ?>/Basic/Sale">ขายสินค้า</a></li>  
        <li><a href="<?php echo $strPath; ?>/Basic/GetSale">รับคืนสินค้า</a></li>
        <li><a href="<?php echo $strPath; ?>/Basic/ManageBill">จัดการบิลขาย</a></li>
        <li><a href="<?php echo $strPath; ?>/Basic/Repair">ซ่อมแซมสินค้า</a></li>
        <li><a href="<?php echo $strPath; ?>/Basic/BillImport">รับเข้าสินค้า</a></li>
        <li><a href="<?php echo $strPath; ?>/Basic/BillDrop">ใบวางบิล</a></li>
        <li><a href="<?php echo $strPath; ?>/Basic/CheckStock">เช็คสต็อก</a></li>
        <li><a href="<?php echo $strPath; ?>/Basic/ChangeProfile">เปลี่ยนรหัสผ่าน</a></li>
        <li><a href="<?php echo $strPath; ?>/Site/Logout" onclick="return confirm('ออกจากระบบ')">ออกจากระบบ</a></li>

      </ul>
    </li>

    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        สั่งซื้อ/รับสินค้า/ส่งสินค้า<b class="caret"></b>
      </a>
      <ul class="dropdown-menu">

        <?php $strPath= Yii::app()->baseUrl; ?>
        <li><a href="<?php echo $strPath; ?>/PurchaseOrder/PO">สั่งซื้อ</a></li> 
        <li><a href="<?php echo $strPath; ?>/Shiping/Ship">ส่งสินค้า</a></li>
      

      </ul>
    </li>
    
    <?php $user = User::model()->findByPk(Yii::app()->request->cookies['user_id']->value); ?>
    <?php if (!empty($user)): ?>
		<?php if ($user->user_level == "admin"): ?>
    <li>
      <a href="#" data-toggle="dropdown" class="dropdown-toggle">
        รายงาน<b class="caret"></b>
      </a>
      <ul class="dropdown-menu">
        <li class="dropdown-submenu">
          <a href="#" data-toggle="dropdown" class="dropdown-toggle">
            รายงานยอดขาย
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo $strPath; ?>/Report/SalePerDay">ยอดขายประจำวัน</a></li>
            <li><a href="<?php echo $strPath; ?>/Report/SaleSumPerDay">สรุปยอดขายตามวัน</a></li>
            <li><a href="<?php echo $strPath; ?>/Report/SaleSumPerMonth">สรุปยอดขายตามเดือน</a></li>
            <li><a href="<?php echo $strPath; ?>/Report/SaleSumPerType">สรุปยอดขายตามประเภท</a></li>
            <li><a href="<?php echo $strPath; ?>/Report/SaleSumPerMember">สรุปยอดขายตามสมาชิก</a></li>
            <li><a href="<?php echo $strPath; ?>/Report/SaleSumPerEmployee">สรุปยอดขายตามพนักงาน</a></li>
          </ul>
        </li>
        <li><a href="<?php echo $strPath; ?>/ProductStock">รายงานสินค้า</a></li>
        <li><a href="<?php echo $strPath; ?>/Report/ReportAR">รายงานลูกหนี้</a></li>
        <li><a href="<?php echo $strPath; ?>/Report/ReportIR">รายงานเจ้าหนี้</a></li>
      </ul>
    </li>

   
  




    <li class="dropdown">
      <a href="#" data-toggle="dropdown" class="dropdown-toggle">
        ตั้งค่าพื้นฐาน<b class="caret"></b>
      </a>
      <ul class="dropdown-menu">
        <li><a href="<?php echo $strPath; ?>/Config/Organization">ข้อมูลร้านค้า</a></li>
        <li><a href="<?php echo $strPath; ?>/Config/BranchIndex">คลังสินค้า/สาขา</a></li>
        <li><a href="<?php echo $strPath; ?>/Config/GroupProductIndex">ประเภทสินค้า</a></li>
        <li><a href="<?php echo $strPath; ?>/Config/ProductIndex">สินค้า</a></li>
        <li><a href="<?php echo $strPath; ?>/Config/FarmerIndex">ตัวแทนจำหน่าย</a></li>
        <li><a href="<?php echo $strPath; ?>/Config/MemberIndex">สมาชิกร้าน</a></li>
        <li><a href="<?php echo $strPath; ?>/Config/UserIndex">ผู้ใช้งานระบบ</a></li>
        <li><a href="<?php echo $strPath; ?>/Config/BillConfigIndex">ตั้งค่าการพิมพ์บิล</a></li>
      </ul>
    </li>
    <?php endif; ?>
    <?php endif; ?>
    
    <!--<li><a href="index.php?r=Config/About">เกี่ยวกับโปรแกรม</a></li>-->
  </ul>
</div>
<?php endif; ?>

