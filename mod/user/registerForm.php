<script type="text/javascript">
   var RecaptchaOptions = {
      theme : 'clean'
   };
</script>
<h2>Registration form</h2>
<form action="<?php echo $base_url; ?>user.register" method="post" name="user-register" id="user-register">
   Please enter your details below. Every field is mandatory.
   <table cellpadding="0" cellspacing="8" id="user-register-table">
      <tr>
         <td><label for="reguname">Username:</label></td>
         <td><input autocomplete="off" id="user-register-uname" name="reguname" maxlength="32" type="text" value='<?php if (isset($_POST['reguname'])){  echo $_POST['reguname']; } ?>' />
            <br />
            Must consists of 3-32 characters.</td>
      </tr>
      <tr>
         <td><label for="regpswd">Password:</label></td>
         <td><input autocomplete="off" id="user-register-pswd" name="regpswd" maxlength="32" type="password" value='<?php if (isset($_POST['regpswd'])){  echo $_POST['regpswd']; } ?>'  />
            <br />
            Must consists of 6-32 characters.</td>
      </tr>
      <tr>
         <td><label for="regrealname">Real name:</label></td>
         <td><input autocomplete="off" id="user-register-realname" name="regrealname" maxlength="128" type="text" value='<?php if (isset($_POST['regrealname'])){  echo $_POST['regrealname']; } ?>'  />
            <br />
            Input your real name.</td>
      </tr>
      <tr>
         <td><label for="regemail">E-mail:</label></td>
         <td><input autocomplete="off" id="user-register-email" name="regemail" maxlength="64" type="text" value='<?php if (isset($_POST['regemail'])){  echo $_POST['regemail']; } ?>'  />
            <br />
            Input your valid e-mail address.</td>
      </tr>
      <tr>
         <td><label for="regschool">Institution:</label></td>
         <td><input autocomplete="off" id="user-register-school" name="regschool" type="text" maxlength="128" value='<?php if (isset($_POST['regschool'])){  echo $_POST['regschool']; } ?>' />
            <br />
            Input your institution/ school/ company.</td>
      </tr>
      <tr>
         <?php
         /**************************************************************
         *
         *  RECAPTCHA
         *
         */
         ?>
         <td colspan="2"><br/>
            <?php
               echo recaptcha_get_html($publickey, $error);
            ?>
            <br />
            <label>
            <input name="regterm" id="user-register-term" type="checkbox" />
            I agree to accept the <a href="<?php echo $base_url; ?>tos">terms and privacy policy</a> of this site. </label>
            <br />
            <input name="regsubmit" id="user-register-submit" type="submit" value="Register" />
         </td>
      </tr>
   </table>
</form>
