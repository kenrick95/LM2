<h2>View user</h2>
<table border='0' cellspacing='8' cellpadding='0' id="viewuser-table">
  <tr>
   <td >ID</td>
   <td><?php
       echo $data['uid'];
       ?>
   </td>
  </tr>
  <tr>
   <td >Username:</td>
   <td><?php
       echo $data['uname'];
       ?>
   </td>
  </tr>
  <!--
  <tr>
   <td>Password (encrypted):</td>
   <td><?php
       #echo $data['upassword'];
       ?>
   </td>
  </tr>
  -->
  <tr>
   <td>Real name: </td>
   <td><?php
       echo $data['urealname'];
       ?>
   </td>
  </tr>
  <tr>
   <td >Institution: </td>
   <td><?php
       echo $data['uschool'];
       ?></td>
  </tr>
  <tr>
   <td>User role: </td>
   <td>
   <?php
       $drole=$data['urole'];
       switch ($drole) {
         case 0:$drolename="User"; break;
         case 1:$drolename="ANT-ers"; break;
         case 2:$drolename="Editor"; break;
         case 3:$drolename="Supervisor"; break;
         case 4:$drolename="Administrator"; break;
      }
      echo $drolename;
    ?>
   
   </td>
   </tr>
</table>
