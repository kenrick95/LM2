<?php
global $konek;
?>
<script type="text/javascript" src="<?php echo $base_url; ?>assets/resc/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>assets/js/ckedit.js"></script>
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
<form id="editform" name="editform" method="POST" action="<?php echo $base_url; ?>index.php?mod=prob&action=save">
<?php
   if ((isset($pid)) && ($pid != "")){
      $per = "SELECT * FROM pcdb_prob WHERE pid='$pid'";
      $hasil= mysql_query($per, $konek);
      $data=mysql_fetch_array($hasil);
      $ptitle = $data['ptitle'];
      $ptim=$data['ptim'];
      $pmem=$data['pmem'];
      
   } else {
      $content="";
      $ptitle="";
      $ptim = "";
      $pmem = "";
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
            <input type='text' name='pmem' title='Memory limit' value="<?php echo $pmem; ?>"  /> 
         </td>
      </tr>
      <tr>
         <td>
            <label for="pmem">Time limit (in second): </label>
         </td>
         <td>
            <input type='text' name='ptim' title='Time limit' value="<?php echo $ptim; ?>" /> 
         </td>
      </tr>
   </table>
   <br />
<?php
   }
?>
   <textarea cols='80' id='edtr' name='edtr' rows='20'>
      <?php echo $content; ?>
   </textarea>
   <br />

<?php
   if (($type == "prob") || ($type == "newprob")) {
?>
   <table>
      <tr>
         <td colspan='2'>Testcase:<br /><b>Li</b>hat <b>ma</b>salah uses "ACM-ICPC Mode"</td>
      </tr>
      <tr>
         <td>Judge input (<?php echo $pid; ?>.in):<br />
            <textarea cols='30' id='tcinp' name='tcinp' rows='10' class='codeeditor'><?php echo $tcin; ?></textarea></td>
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
   <input type="hidden" name="id" value="<?php
      if ((isset($pid)) && ($pid != "")){
         echo $pid;
      } else {
         echo "new";
      }
   ?>" />
   
</form>

<script type='text/javascript'>
   jsx();
</script>