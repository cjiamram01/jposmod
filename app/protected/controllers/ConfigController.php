<?php

class ConfigController extends Controller {

  function actionOrganization() {
    $model = Organization::model()->find();

    if (!empty($_POST)) {
      $model->attributes = $_POST["Organization"];

      // show logo on bill
      $org_logo_show_on_bill = $_POST['org_logo_show_on_bill'];
      $on_bill = 'no';

      if ($org_logo_show_on_bill == 1) {
        $on_bill = 'yes';
      }

      $model->org_logo_show_on_bill = $on_bill;

      // logo
      $org_logo = CUploadedFile::getInstance($model, 'org_logo');
      $old_logo = $model->org_logo;

      if (!empty($org_logo)) {
        $model->org_logo = $org_logo;
        $model->org_logo->saveAs('upload/' . $org_logo);

        // remove old logo
        if (file_exists('upload/' . $old_logo)) {
          @unlink('upload/' . $old_logo);
        }
      }

      $model->save();
    }
    $this->render("//Config/Organization", array('model' => $model));
  }

  function actionBranchIndex() {
    $model = new Branch();
    $this->render("//Config/BranchIndex", array('model' => $model));
  }

  function actionBranchForm($id = null) {
    $model = new Branch();

    if (!empty($_POST)) {
      $pk = $_POST["Branch"]["branch_id"];

      if (!empty($pk)) {
        $model = Branch::model()->findByPk($pk);
      }
      $model->attributes = $_POST["Branch"];

      if ($model->save()) {
        $this->redirect(array('BranchIndex'));
      }
    }

    if ($id != null) {
      $model = Branch::model()->findByPk($id);
    }
    $this->render('//Config/BranchForm', array('model' => $model));
  }

  function actionBranchDelete($id) {
    Branch::model()->deleteByPk($id);
    $this->redirect(array('BranchIndex'));
  }

  function actionGroupProductIndex() {
    $model = new GroupProduct();
    $this->render('//Config/GroupProductIndex', array('model' => $model));
  }

  function actionGroupProductForm($id = null) {
    $model = new GroupProduct();

    if (!empty($_POST)) {
      $pk = $_POST["GroupProduct"]["group_product_id"];

      if (!empty($pk)) {
        $model = GroupProduct::model()->findByPk($pk);
      }
      $model->attributes = $_POST["GroupProduct"];

      if ($model->save()) {
        $this->redirect(array('GroupProductIndex'));
      }
    }

    if (!empty($id)) {
      $model = GroupProduct::model()->findByPk($id);
    }
    $this->render('//Config/GroupProductForm', array('model' => $model));
  }

  function actionGroupProductDelete($id) {
    GroupProduct::model()->deleteByPk($id);
    $this->redirect(array('GroupProductIndex'));
  }

  function actionProductIndex() {
    $model = new Product();
    $this->render('//Config/ProductIndex', array('model' => $model));
  }

  function actionProductForm($id = null) {
    $model = new Product();
    $default_product_expire = 'expire';
    $default_product_return = 'in';
    $default_product_sale_condition = 'sale';

    if (!empty($_POST)) {
      $pk = $_POST["Product"]["product_id"];

      if (!empty($pk)) {
        $model = Product::model()->findByPk($pk);
      }

      $model->attributes = $_POST["Product"];

      // process total small unit
      if (!empty($_POST['Product']['product_quantity_of_pack'])) {
        $total = ($model->product_total_per_pack * $model->product_quantity_of_pack);
        $model->product_quantity = $total;
      }
			
			// product_expire_date
			if (!empty($_POST['Product']['product_expire_date'])) {
				$product_expire_date = $_POST['Product']['product_expire_date'];
				$model->product_expire_date = Util::thaiToMySQLDate($product_expire_date);
			}

      // save
      if ($model->save()) {
        $this->redirect(array('ProductIndex'));
      }
    }

    if (!empty($id)) {
      $model = Product::model()->findByPk($id);
    } else {
      $model->product_total_per_pack = 1;
    }
    
    $params['model'] = $model;
    $params['default_product_expire'] = $default_product_expire;
    $params['default_product_return'] = $default_product_return;
    $params['default_product_sale_condition'] = $default_product_sale_condition;
    
    $this->render('//Config/ProductForm', $params);
  }

  function actionProductDelete($id) {
    Product::model()->deleteByPk($id);
    $this->redirect(array('ProductIndex'));
  }

  function actionFarmerIndex() {
    $model = new Farmer();
    $this->render('//Config/FarmerIndex', array(
        'model' => $model
    ));
  }

  function actionFarmerForm($id = null) {
    $model = new Farmer();

    if (!empty($_POST)) {
      $pk = $_POST['Farmer']['farmer_id'];

      if (!empty($pk)) {
        $model = Farmer::model()->findByPk($pk);
      }
      $model->attributes = $_POST['Farmer'];

      if ($model->save()) {
        $this->redirect(array('FarmerIndex'));
      }
    }

    if (!empty($id)) {
      $model = Farmer::model()->findByPk($id);
    }
    $this->render('//Config/FarmerForm', array(
        'model' => $model
    ));
  }

  function actionFarmerDelete($id) {
    Farmer::model()->deleteByPk($id);
    $this->redirect(array('FarmerIndex'));
  }

  function actionMemberIndex() {
    $model = new Member();
    $this->render('//Config/MemberIndex', array(
        'model' => $model
    ));
  }

  function actionMemberForm($id = null) {
    $model = new Member();

    if (!empty($_POST)) {
      $pk = $_POST['Member']['member_id'];

      if (!empty($pk)) {
        $model = Member::model()->findByPk($pk);
      }

      $model->attributes = $_POST["Member"];
			
			// save branch_id
			if (empty($_POST['Member']['branch_id'])) {
				$user_id = Yii::app()->request->cookies['user_id']->value;
				$user = User::model()->findByPk($user_id);
				
				$model->branch_id = $user->branch_id;
			}

      if ($model->save()) {
        $this->redirect(array('MemberIndex'));
      }
    }

    if (!empty($id)) {
      $model = Member::model()->findByPk($id);
    }

    $this->render('//Config/MemberForm', array(
        'model' => $model
    ));
  }

  function actionMemberDelete($id = null) {
    Member::model()->deleteByPk($id);
    $this->redirect(array('MemberIndex'));
  }

  function actionUserIndex() {
    $model = new User();
    $this->render('//Config/UserIndex', array(
        'model' => $model
    ));
  }

  function actionUserForm($id = null) {
    $model = new User();

    if (!empty($_POST)) {
      $pk = $_POST["User"]["user_id"];
      if (!empty($pk)) {
        $model = User::model()->findByPk($id);
      }

      $model->attributes = $_POST["User"];

      if ($model->save()) {
        $this->redirect(array('UserIndex'));
      }
    }

    if (!empty($id)) {
      $model = User::model()->findByPk($id);
    }
    $this->render('//Config/UserForm', array(
        'model' => $model
    ));
  }

  function actionUserDelete($id) {
    User::model()->deleteByPk($id);
    $this->redirect(array('UserIndex'));
  }
	
	function actionBillConfigIndex() {
		$billConfig = BillConfig::model()->find();
		
		if (empty($billConfig)) {
			$billConfig = new BillConfig();
		}
		
		// Save
		if (!empty($_POST)) {
			$billConfig->_attributes = $_POST['BillConfig'];
			
			if ($billConfig->save()) {
				$this->redirect(array('BillConfigIndex'));
			}
		}
		
		$this->render('//Config/BillConfigIndex', array(
			'billConfig' => $billConfig
		));
	}

  function actionAbout() {
    $this->render('//Config/About');
  }

}