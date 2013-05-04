<h2>Problem list</h2>
   
   Page <?php echo $page; ?> of <?php echo $num_page; ?>
   <br />
   Go to page: 
   <?php
      for($i=1; $i<=$num_page; $i++) {
         ?>
            <a href="<?php echo $base_url; ?>problem.list.<?php echo $i; ?>"><?php echo $i; ?></a>
         <?php
            if ($i != $num_page) {
               ?>
                  &nbsp;&middot;&nbsp;
               <?php
            }
      }
   ?>
   <br />
   <table cellpadding="0" cellspacing="0" id="content-managepost">
   <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Time limit (s)</th>
      <th>Memory limit (kB)</th>
      <th>Submitted</th>
      <th>AC</th>
      <th>Not AC</th>
      <th>License</th>
      <th>Attribution</th>
      <th>Settings</th>
   </tr>
<?php
   while ($data=mysqli_fetch_array($qry)) {
?>
<tr>
   <td><a href="problem.view.<?php
      echo $data['pid'];
   ?>"><?php
      echo $data['pid'];
   ?></a>
   </td>
   <td><?php
      echo $data['ptitle'];
   ?>
   </td>
   <td><?php
      echo $data['ptim'];
   ?>
   </td>
   <td><?php
      echo $data['pmem'];
   ?>
   </td>
   <td><?php
      echo $data['psubmit'];
   ?>
   </td>
   <td><?php
      echo $data['pac'];
   ?>
   </td>
   <td><?php
      echo $data['pnac'];
   ?>
   </td>
   <td><?php
      echo $data['plicense'];
   ?>
   </td>
   <td><?php
      echo $data['pattr'];
   ?>
   </td>
   
   <td><a href="<?php echo $base_url; ?>problem.edit.<?php echo $data['pid']; ?>">Edit</a><?php
      if ($_urole>=2) {
   ?>&nbsp;<a href="<?php echo $base_url; ?>problem.delete.<?php echo $data['pid']; ?>">Delete</a>
   <?php
      }
   ?></td>
   </tr>
<?php
}
?>
</table>
