<div class="profile-content">
   <div class="row">
      <div class="col-md-12"> 
         <form action="/cp/editPersonalInfo/" class="onsubmit" data-redirect="/cp/settings/">
                        <div class="form-group">
                           <label class="control-label">Login</label>
                           <input type="text" class="form-control" id="disabledInput" disabled value="<?=$userdata['login']?>"/>
                        </div>

                        <div class="form-group">
                           <label class="control-label">Current Password <span class="req">*</span></label>
                           <input type="password" class="form-control" name="current_password"/>
                        </div>
                        <div class="form-group">
                           <label class="control-label">New Password <span class="req">*</span></label>
                           <input type="password" class="form-control new_password" name="password" data-size="6" data-character-set="a-z,A-Z,0-9,#"/>
                           <br>
                           <button type="button" id="generate_new_password" class="btn btn-circle btn-danger btn-sm">Generate password</button>
                           <button type="button" id="view_password" style="display:none;" class="btn btn-circle btn-info btn-sm"><i class="fa fa-eye"></i> <span>Show</span></button>
                           <button type="button" id="copy" style="display:none;" class="btn btn-circle btn-success btn-sm"><i class="fa fa-files-o" aria-hidden="true"></i> <span>Copy</span></button>
                        </div>
                        <div class="form-group">
                           <label class="control-label">Re-type New Password <span class="req">*</span></label>
                           <input type="password" class="form-control repeat_password" name="repeat_password"/>
                        </div>
                        <div class="margin-top-10">
                           <button type="submit" class="btn green">Save</button> 
                        </div>
                     </form> 
      </div>
   </div>
</div>