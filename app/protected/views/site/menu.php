<?php if (Yii::app()->request->cookies['user_id'] != null): ?>
<div class="navbar navbar-default">
  <ul class="nav navbar-nav">
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        บันทึกประจำวัน<b class="caret"></b>
      </a>
      <ul class="dropdown-menu">
        <li><a href="index.php?r=Basic/Sale">ขายสินค้า</a></li>	
        <li><a href="index.php?r=Basic/GetSale">รับคืนสินค้า</a></li>
        <li><a href="index.php?r=Basic/ManageBill">จัดการบิลขาย</a></li>
        <li><a href="index.php?r=Basic/Repair">ซ่อมแซมสินค้า</a></li>
        <li><a href="index.php?r=Basic/BillImport">รับเข้าสินค้า</a></li>
        <li><a href="index.php?r=Basic/BillDrop">ใบวางบิล</a></li>
        <li><a href="index.php?r=Basic/CheckStock">เช็คสต็อก</a></li>
        <li><a href="index.php?r=Basic/ChangeProfile">เปลี่ยนรหัสผ่าน</a></li>
        <li><a href="index.php?r=Site/Logout" onclick="return confirm('ออกจากระบบ')">ออกจากระบบ</a></li>
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
            <li><a href="index.php?r=Report/SalePerDay">ยอดขายประจำวัน</a></li>
            <li><a href="index.php?r=Report/SaleSumPerDay">สรุปยอดขายตามวัน</a></li>
            <li><a href="index.php?r=Report/SaleSumPerMonth">สรุปยอดขายตามเดือน</a></li>
            <li><a href="index.php?r=Report/SaleSumPerType">สรุปยอดขายตามประเภท</a></li>
            <li><a href="index.php?r=Report/SaleSumPerMember">สรุปยอดขายตามสมาชิก</a></li>
            <li><a href="index.php?r=Report/SaleSumPerEmployee">สรุปยอดขายตามพนักงาน</a></li>
          </ul>
        </li>
        <li><a href="index.php?r=Report/ProductStock">รายงานสินค้า</a></li>
        <li><a href="index.php?r=Report/ReportAR">รายงานลูกหนี้</a></li>
        <li><a href="index.php?r=Report/ReportIR">รายงานเจ้าหนี้</a></li>
      </ul>
    </li>

    <li class="dropdown">
      <a href="#" data-toggle="dropdown" class="dropdown-toggle">
        ตั้งค่าพื้นฐาน<b class="caret"></b>
      </a>
      <ul class="dropdown-menu">
        <li><a href="index.php?r=Config/Organization">ข้อมูลร้านค้า</a></li>
        <li><a href="index.php?r=Config/BranchIndex">คลังสินค้า/สาขา</a></li>
        <li><a href="index.php?r=Config/GroupProductIndex">ประเภทสินค้า</a></li>
        <li><a href="index.php?r=Config/ProductIndex">สินค้า</a></li>
        <li><a href="index.php?r=Config/FarmerIndex">ตัวแทนจำหน่าย</a></li>
        <li><a href="index.php?r=Config/MemberIndex">สมาชิกร้าน</a></li>
        <li><a href="index.php?r=Config/UserIndex">ผู้ใช้งานระบบ</a></li>
        <li><a href="index.php?r=Config/BillConfigIndex">ตั้งค่าการพิมพ์บิล</a></li>
      </ul>
    </li>
    <?php endif; ?>
    <?php endif; ?>
    
    <!--<li><a href="index.php?r=Config/About">เกี่ยวกับโปรแกรม</a></li>-->
  </ul>
</div>
<?php endif; ?>

