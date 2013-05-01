<h2>Manage Users</h2>
   
   Page <?php echo $page; ?> of <?php echo $num_page; ?>
   <br />
   Go to page: 
   <?php
      for($i=1; $i<=$num_page; $i++) {
         ?>
            <a href="<?php echo $base_url; ?>user.manage.<?php echo $i; ?>"><?php echo $i; ?></a>
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
      <th>Username</th>
      <th>Real name</th>
      <th>Institution</th>
      <th>Role</th>
      <th>Settings</th>
   </tr>
<?php
   while ($data=mysqli_fetch_array($qry)) {
?>
<tr>
   <td><?php
      echo $data['uid'];
      ?>
   </td>
   <td><?php
      echo $data['uname'];
    ?>
   </td>
  <!--
   <td><?php
       #echo $data['upassword'];
       ?>
   </td>
  -->
  <td><?php
    echo $data['urealname'];
    ?>
   </td>
   <td><?php
    echo $data['uschool'];
    ?>
    </td>
    <td>
   <?php
       $drole=$data['urole'];
       switch ($drole) {
         case 0:$drolename="User"; break;
         case 1:$drolename="Editor"; break;
         case 2:$drolename="Judge"; break;
         case 3:$drolename="Supervisor"; break;
         case 4:$drolename="Administrator"; break;
      }
      echo $drolename;
    ?>
    </td>
    <td><a href="<?php echo $base_url; ?>user.edit.<?php echo $data['uid']; ?>">Edit</a><!--&nbsp;<a href="<?php echo $base_url; ?>user.delete.<?php echo $data['uid']; ?>">Delete</a>--></td>
    </tr>
<?php
}
?>
</table>
