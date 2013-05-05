<?php
global $konek;
?>
<script type="text/javascript" src="<?php echo $base_url; ?>assets/resc/ckeditor/ckeditor.js"></script>
<?php
/*
<!--
<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/ckedit.js"></script>-->
*/ ?>
<?php
if ($type == "prob") {
?>
<h2>Editing problem</h2>
<?php
} else if ($type == "newprob") {
?>
<h2>New problem</h2>
<?php
} else if ($type == "sol") {
?>
<h2>Editing solution</h2>
<?php
} else if ($type == "newsol") {
?>
<h2>New solution</h2>
<?php
}
?>
<form id="editform" name="editform" method="POST" action="<?php
   echo $base_url;
   if (($type == "prob") || ($type == "newprob")) {
      echo "problem.";
   } else {
      echo "solution.";
   }
   echo "save.". $pid;
?>">
<?php
   if ((isset($pid)) && ($pid != "")){
      $ptitle = $data['ptitle'];
      $ptim=$data['ptim'];
      $pmem=$data['pmem'];
      $plicense = $data['plicense'];
      $pattr = $data['pattr'];
   } else {
      $content="";
      $ptitle="";
      $ptim = "";
      $pmem = "";
      $plicense = "";
      $pattr = "";
   }
?>
<?php
   if (($type == "prob") || ($type == "newprob")) {
?>
   <table>
      <tr>
         <td>
            <label for="ptitle">Problem title:</label>
         </td>
         <td>
            <input type='text' name='ptitle' title='Problem title' style="width:400px;" value="<?php echo $ptitle; ?>" />
         </td>
      </tr>
      <tr>
         <td>
            <label for="pmem">Memory limit (in kB): </label>
         </td>
         <td>
            <input type='text' name='pmem' title='Memory limit' style="width:400px;" value="<?php echo $pmem; ?>"  /> 
         </td>
      </tr>
      <tr>
         <td>
            <label for="ptim">Time limit (in second): </label>
         </td>
         <td>
            <input type='text' name='ptim' title='Time limit' style="width:400px;" value="<?php echo $ptim; ?>" /> 
         </td>
      </tr>
      <tr>
         <td>
            <label for="plicense">License: </label>
         </td>
         <td>
            <select name="plicense" id="plicense" style="min-width:400px;">
               <option disabled="disabled" value="0" <?php
               if ($plicense == "") {
                  echo "selected=\"selected\"";
               }
               ?>>Choose license</option>
               <option value="Creative Commons Attribution 3.0" <?php if ($plicense == "Creative Commons Attribution 3.0") {
                  echo "selected=\"selected\"";
               }?>>Creative Commons Attribution 3.0 (recommended)</option>
               <option value="Creative Commons Attribution ShareAlike 3.0" <?php if ($plicense == "Creative Commons Attribution ShareAlike 3.0") {
                  echo "selected=\"selected\"";
               }?>>Creative Commons Attribution ShareAlike 3.0</option>
               <option value="GNU Free Documentation License 1.3" <?php if ($plicense == "GNU Free Documentation License 1.3") {
                  echo "selected=\"selected\"";
               }?>>GNU Free Documentation License 1.3</option>
               <option value="Creative Commons Zero" <?php if ($plicense == "Creative Commons Zero") {
                  echo "selected=\"selected\"";
               }?>>Creative Commons Zero</option>
               <option value="Public Domain" <?php if ($plicense == "Public Domain") {
                  echo "selected=\"selected\"";
               }?>>Public Domain</option>
            </select>
         </td>
      </tr>
      <tr>
         <td>
            <label for="pattr">Attribution: </label>
         </td>
         <td>
            <input type='text' name='pattr' title='Attribution' style="width:400px;" value="<?php echo $pattr; ?>" /> 
         </td>
      </tr>
   </table>
   <br />
<?php
   }
?>
   
   <textarea cols='80' id='edtr' name='edtr' rows='20' class="ckeditor">
      <?php echo $content; ?>
   </textarea>
   <?php
   /*
   <!--
   <div id='edtr' contenteditable="true" >
      echo $content;
   </div>-->
   */
   ?>
   <br />

<?php
   if (($type == "prob") || ($type == "newprob")) {
?>
   <table>
      <tr>
         <td colspan='2'><h3>Testcase</h3><!--<b>Li</b>hat <b>ma</b>salah uses "ACM-ICPC Mode"--><small>Currently, only one testcase is supported.</small></td>
      </tr>
      <tr>
         <td>Judge input (<?php echo $pid; ?>.in):<br />
            <textarea cols='30' id='tcinp' name='tcin' rows='10' class='codeeditor'><?php echo $tcin; ?></textarea></td>
         <td>Judge output (<?php echo $pid; ?>.out):<br />
            <textarea cols='30' id='tcout' name='tcout' rows='10' class='codeeditor'><?php echo $tcout; ?></textarea></td>
      </tr>
   </table>
<?php
   }
?>
   
   <input type='submit' value='Save' />
   &emsp;
   <input type="button" name="back" value="Back" onClick="window.history.go(-1);"  />
   
</form>
<?php
/*
<script type='text/javascript'>
   //jsx();
   //CKEDITOR.disableAutoInline = true;
   //var editor = CKEDITOR.inline( 'edtr' );
</script>
*/ ?>
