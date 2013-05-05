<h2>Edit user</h2>
<form action='<?php echo $base_url; ?>user.save' method='post' name='edituser-form' target='_self' id='edituser-form' style='text-align:left;'>
<input type="hidden" name="uid" value="<?php echo $data['uid']; ?>" />
<table border='0' cellspacing='8' cellpadding='0' id="edituser-table">
<tr>
   <td style='vertical-align:top;'><label for="email">E-mail: </label></td>
   <td><input name='email' id='email' type='text' size='32' maxlength='64' value='<?php
       echo $data['uemail'];
       ?>'></td>
  </tr>
  <tr>
   <td style='vertical-align:top;'><label for="realname">Real name: </label></td>
   <td><input name='realname' id="realname" type='text' size='32' maxlength='128' value='<?php
       echo $data['urealname'];
       ?>'></td>
  </tr>
  <tr>
   <td style='vertical-align:top;'><label for="school">Institution: </label></td>
   <td><input name='school' id='school' type='text' size='32' maxlength='128' value='<?php
       echo $data['uschool'];
       ?>'></td>
  </tr>
<?php
      if ($_userrole>=4) {
         ?>
  <tr>
   <td style='vertical-align:top;'><label for="role">Status</label></td>
   <td><select name="role" id="role">
   <?php
       $drole=$data['urole'];
    ?>
   <option value="0" <?php if($drole==0) { echo "selected=\"selected\""; } ?>>User</option>
   <option value="1" <?php if($drole==1) { echo "selected=\"selected\""; } ?>>Editor</option>
   <option value="2" <?php if($drole==2) { echo "selected=\"selected\""; } ?>>Judge</option>
   <option value="3" <?php if($drole==3) { echo "selected=\"selected\""; } ?>>Supervisor</option>
   <option value="4" <?php if($drole==4) { echo "selected=\"selected\""; } ?>>Administrator</option>
   </select>
     </td></tr>
     <tr>
   <td style='vertical-align:top;' colspan="2">
      User status:<br />
      <?php
         require_once "/../prob/main.php";
         $list = new LM2prob("role");
         $content = $list -> getProblemContent();
         echo $content;
      ?>
      </td>
   </tr>
   <?php
   }
   ?>
   <tr>
      <td colspan="2"><input type="submit" value="Save" /></td>
   </tr>
</table>
</form>
<script type="text/javascript">
   $("#role-table tr:even").addClass("table3-clean");
   $("#role-table tr:odd").addClass("table2-clean");
   $("#role-table th").addClass("table1-clean");
</script>
