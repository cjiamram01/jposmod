<?php 
  $org=Organization::model()->findAll();



?>


<div class="panel panel-primary" style="margin: 100px">
  <div class="panel-heading">Login </div>
  <div class="panel-body">
    
    <?php if (Yii::app()->user->hasFlash('message')): ?>
    <div class="alert alert-danger">
      <?php echo Yii::app()->user->getFlash('message'); ?>
    </div>
    <?php endif; ?>
    
    <form method="post" name="formLogin">
  <div class="col-md-12">
  
  <div  style="float:top">
   
    <div >
        <div>
          <label >Username:</label>
            <input type="text" name="User[user_username]" class="form-control"
             style="width: 200px" />
        </div>
        <div>
      <label>Password</label>
      <input type="password" name="User[user_password]" class="form-control"
             style="width: 200px" />
    </div>
    <div>
      <label></label>
      <a href="#" class="btn btn-primary" onclick="formLogin.submit()">
        Login
      </a>
    </div>
    </div>

  </div>
  </div>  
</div>

