 

<?php if (!empty($_SESSION['msg'])): ?>
   <div class="row">
      <div class="col-md-12">
         <?=$_SESSION['msg']?>
         <?php unset($_SESSION['msg'])?>
      </div>
   </div> 
<?php endif ?>

<div id="fade-respond" class="alert"> </div> 
  
 <div class="row margin-top-20">
   <div class="col-md-12">
      <!-- BEGIN PROFILE SIDEBAR --> 

      <div class="tabbable-line boxless tabbable-reversed">
        <ul class="nav nav-tabs">
          <li class="<?=empty($_GET['p']) ? 'active' : '' ?>">
             <a href="/cp/settings">
             <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
             Profile </a>
          </li>
          <li class="<?=!empty($_GET['p']) && $_GET['p'] == 'users' ? 'active' : '' ?>">
             <a href="?p=users">
             <i class="fa fa-users" aria-hidden="true"></i>
             Users </a>
          </li>
          <li class="<?=!empty($_GET['p']) && $_GET['p'] == 'privilege' ? 'active' : '' ?>">
             <a href="?p=privilege">
             <i class="fa fa-unlock-alt" aria-hidden="true"></i>
             Role </a>
          </li>

          <li class="<?=!empty($_GET['p']) && $_GET['p'] == 'settings' ? 'active' : '' ?>">
             <a href="?p=settings">
             <i class="icon-settings"></i>
             Settings </a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active">
          <br> 
             <?=$this->load->view('private/settings/'.$view)?>
          </div>
        </div>
      </div>


   </div>
</div>
 <style>
   .font-red-sunglo{
      color: #333 !important;
   }

   .profile-sidebar-portlet{
      padding-top: 0 !important;
   }
 </style>

<script>
   function randString(id){
     var dataSet = $(id).attr('data-character-set').split(','); 
     
     var possible = '';
     if($.inArray('a-z', dataSet) >= 0){
       possible += 'abcdefghijklmnopqrstuvwxyz';
     }

     if($.inArray('A-Z', dataSet) >= 0){
       possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
     }

     if($.inArray('0-9', dataSet) >= 0){
       possible += '0123456789'; 
     }

     if($.inArray('#', dataSet) >= 0){
       possible += '![]{}()%&*$#^<>~@|';
     }

     var text = '';
     for(var i=0; i < $(id).attr('data-size'); i++) {
       text += possible.charAt(Math.floor(Math.random() * possible.length));
     }  

    var validate = validatePass(text);
    if (validate === true) {
      return text;
    }else{ 
      randString(id);
      unbind(id);
    }  
  }

  function validatePass(pass){
    if(!pass.match("(?=.*[a-z])"))
    {
      return false;
    } 

    if(!pass.match("(?=.*[A-Z])"))
    {
      return false;
    } 

    var regex = /[^\w\s]/gi; 
    if(!regex.test(pass)) {
      return false;
    }

    return true;
  }


    var text = 'SSs';
     

 
   // Create a new password
   $("#generate_new_password").click(function(){
     var password = randString('.new_password'); 

     $('#copy').html('<i class="fa fa-files-o" aria-hidden="true"></i> <span>Copy</span>');
     $('#copy').attr('disabled', false);

     $('.new_password, .repeat_password').val(password); 

     $('#view_password').show();
     $('#copy').show();
   });

   $('#view_password').click(function(){
      var text = $(this).find('span').text();
      if (text == "Show") {  
         $('button#view_password').html('<i class="fa fa-eye-slash" aria-hidden="true"></i> <span>Hide</span>'); 
         $('input.new_password, input.repeat_password').attr('type', 'text');  
      } else if(text == 'Hide')  {  
        $('button#view_password').html('<i class="fa fa-eye" aria-hidden="true"></i> <span>Show</span>'); 
        $('input.new_password, input.repeat_password').attr('type', 'password'); 
      }  
   });

   $('#copy').click(function(){ 
      copyToClipboard('input.new_password');
      $('#copy').html('<i class="fa fa-files-o" aria-hidden="true"></i> <span>Copied</span>');
      $('#copy').attr('disabled', true);
   });

    function copyToClipboard(element) {
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(element).val()).select();
      document.execCommand("copy");
      $temp.remove();
    }

    function changeType(item){
      var val = $(item).val();
      var id = $(item).attr('data-id'); 
      $.ajax({
        type:'POST', 
        url: '/cp/changeUsrType/', 
        async: true,
        data: {'type': val, 'id': id}
      }); 
    } 
</script>