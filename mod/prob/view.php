<table id="problem-info">
   <tr>
      <td colspan="4" style="font-weight:bold;">Problem Information</td>
   </tr>
   <tr>
      <td style="width:100px;">Problem ID:</td>
      <td style="min-width:250px;"><?php echo $data['pid']; ?></td>
      <td colspan="2">&nbsp;</td>
   </tr>
   <tr>
      <td>Memory limit:</td>
      <td><?php echo $data['pmem']; ?>kB</td>
      <td style="width:100px;">License:</td>
      <td style="min-width:250px;"><?php echo $data['plicense']; ?></td>
   </tr>
   <tr>
      <td>Time limit:</td>
      <td><?php echo $data['ptim']; ?>s</td>
      <td>Attribution:</td>
      <td><?php echo $data['pattr']; ?></td>
   </tr>

</table>
<?php
   echo $data['probContent'];
?>
