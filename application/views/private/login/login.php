 
<form class="login-form" action="/login/" method="POST">
   <h3 class="form-title">Login to your account</h3>
   <?=echoSession()?>
   <div class="form-group">
      <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
      <label class="control-label visible-ie8 visible-ie9">Login</label>
      <div class="input-icon">
         <i class="fa fa-user"></i>
         <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Login" name="login"/>
      </div>
   </div>
   <div class="form-group">
      <label class="control-label visible-ie8 visible-ie9">Password</label>
      <div class="input-icon">
         <i class="fa fa-lock"></i>
         <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"/>
      </div>
   </div>
   <div class="form-actions" style="border-bottom:none;">
      <label class="checkbox"> </label>
      <button type="submit" class="btn green-haze pull-right">
      Log in <i class="m-icon-swapright m-icon-white"></i>
      </button>
   </div> 
</form>
