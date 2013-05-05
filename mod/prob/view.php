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
<!--
<?php
   
   echo $data['psubmit'];
   echo $data['pac'];
   echo $data['pnac'];
   echo $data['pwa'];
   echo $data['pacall'];
   echo $data['pnotrun'];
   echo $data['pce'];
   echo $data['prte'];
   echo $data['ptle'];
   echo $data['pmle'];
   echo $data['pisc'];
   echo $data['pir'];
?>
-->
</table>
<?php
   if ($show_stat) {
      ?>
      <h2>Problem statistics</h2>
      <table id="problem-stat">
         <tr class="table1">
            <th colspan="3" style="text-align:center;">Total submission</th>
            <td><?php echo $data['psubmit']; ?></td>
         </tr>
         <tr>
            <th class="table2" style="width:200px;">Total accepted</th>
            <td class="table2" style="width:100px;"><?php echo $data['pacall']; ?></td>
            <th class="table3" style="width:200px;">Total not accepted</th>
            <td class="table3" style="width:100px;"><?php echo $data['pnac']; ?></td>
         </tr>
         
         <tr>
            <th class="table2">Distinct accepted</th>
            <td class="table2"><?php echo $data['pac']; ?></td>
            <th class="table4">Wrong answer</th>
            <td class="table4"><?php echo $data['pwa']; ?></td>
         </tr>
         <tr>
            <th class="table1">Not running</th>
            <td class="table1"><?php echo $data['pnotrun']; ?></td>
            <th class="table3">Compilation error</th>
            <td class="table3"><?php echo $data['pce']; ?></td>
         </tr>
         <tr>
            <td rowspan="5" colspan="2" class="table4">
               Note: "Not running" may be counted as Accepted if it was submitted as Text.
            </td>
            <th class="table4">Runtime error</th>
            <td class="table4"><?php echo $data['prte']; ?></td>
         </tr>
         <tr>
            <th class="table3">Time limit exceeded</th>
            <td class="table3"><?php echo $data['ptle']; ?></td>
         </tr>
         <tr>
            <th class="table4">Memory limit exceeded</th>
            <td class="table4"><?php echo $data['pmle']; ?></td>
         </tr>
         <tr>
            <th class="table3">Illegal system call</th>
            <td class="table3"><?php echo $data['pisc']; ?></td>
         </tr>
         <tr>
            <th class="table4">Internal error</th>
            <td class="table4"><?php echo $data['pir']; ?></td>
         </tr>
      </table>
      <?php
   } else {
      echo $data['probContent'];
   }
?>
