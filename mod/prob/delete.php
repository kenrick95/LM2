<?php
global $konek;
?>

<?php
if ($type == "prob") {
?>
<h2>Deleting problem</h2>
<?php
} else if ($type == "sol") {
?>
<h2>Deleting solution</h2>
<?php
}
?>
<form id="editform" name="editform" method="POST" action="<?php
   echo $base_url;
   if ($type == "prob") {
      echo "problem.";
   } else {
      echo "solution.";
   }
   echo "confirmdelete.". $pid;
?>">
<?php
   if ((isset($pid)) && ($pid != "")){
      $per = "SELECT * FROM pcdb_prob WHERE pid='$pid'";
      $hasil= mysqli_query($konek, $per);
      $data=mysqli_fetch_array($hasil);
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
   <table>
      <tr>
         <td>
            Problem title:
         </td>
         <td>
            <?php echo $ptitle; ?>
         </td>
      </tr>
      <tr>
         <td>
            Memory limit:
         </td>
         <td>
            <?php echo $pmem; ?> kB
         </td>
      </tr>
      <tr>
         <td>
            Time limit:
         </td>
         <td>
            <?php echo $ptim; ?> second(s)
         </td>
      </tr>
   </table>
   <br />
   <?php echo $content; ?>
   <br />
   Are you sure you want to delete this <?php
      if ($type == "prob") {
         echo "problem";
      } else {
         echo "solution";
      }
   ?>?
   <br />
   <input type='submit' value='Delete' />
   &emsp;
   <input type="button" name="back" value="Cancel" onClick="window.history.go(-1);"  />
   
</form>

