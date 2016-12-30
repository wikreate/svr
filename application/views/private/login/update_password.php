 
 <form class="login-form" action="/updatePassword/?token=<?=@$_SESSION['admin_user']['token']?>" method="POST">
 
<h3 class="form-title">Update password</h3>  
   <?=echoSession()?>
    <div class="form-group">
      <label class="control-label visible-ie8 visible-ie9">Old Password</label>
      <div class="input-icon">
         <i class="fa fa-lock"></i>
         <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Old Password" name="old_password"/>
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label visible-ie8 visible-ie9">New Password</label>
      <div class="input-icon">
         <i class="fa fa-lock"></i>
         <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="New Password" name="password"/>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label visible-ie8 visible-ie9">Repeat new Password</label>
      <div class="input-icon">
         <i class="fa fa-lock"></i>
         <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Repeat new Password" name="repeat_password"/>
      </div>
    </div>

    <div class="form-actions" style="border-bottom:none;">
      <label class="checkbox"> </label>
      <button type="submit" class="btn green-haze pull-right">
      Save and Log in <i class="m-icon-swapright m-icon-white"></i>
      </button>
    </div> 
</form>
 
 