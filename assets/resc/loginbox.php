<?php
if (loggedin()) {
?>

<div id="sign-box">
	<div id="user-data-up">
		<div id="user-data-name"> <a href="<?php echo $base_url; ?>user.view.<?php echo $_userid; ?>">
			<?php 
				echo $_urealname;
				?>
			</a> </div>
		<div id="user-data-edit"> [<a href="<?php echo $base_url; ?>user.edit.<?php echo $_userid; ?>">edit</a>] </div>
		<div id="user-data-rolename">
			<?php
				echo $_userrolename;
			?>
		</div>
	</div>
	<div id="user-data-down">
		<div id="user-data-stat">
			<table cellpadding='0' border='0' id="user-data-stat-istic" >
				<tr>
					<td style="width:60%">Institution:</td>
					<td style="width:40%"><?php echo $_uschool; ?></td>
				</tr>
				<tr>
					<?php
							if ($_userrole>1) {
						?>
					<td colspan="2">Tools:<br />
						<ul>
							<li><a href="<?php echo $base_url; ?>news.add">Add new news</a></li>
							<li><a href="<?php echo $base_url; ?>news.manage">Manage news</a></li>
							<?php
								if ($_userrole>=4) {
							?>
							<li><a href="<?php echo $base_url; ?>user.manage">Manage users</a></li>
							<?php
								}
							?>
						</ul></td>
					<?php
							}
						?>
				</tr>
			</table>
		</div>
		<div id="sign-msg"></div>
		<button id="sign-out">Log out</button>
	</div>
</div>
<?php			
} else {
?>
<div id="sign-box">
	<form id="sign-form" name="sign-form" action="javascript:void(0);">
		<label for="sign-uid">Username:</label>
		&nbsp; <a id="sign-register" href="<?php echo $base_url; ?>user.register">Register</a> <br />
		<input type="text" name="sign-uid" id="sign-uid" />
		<br />
		<label for="sign-pass">Password: </label>
		<br />
		<input type="password" name="sign-pass" id="sign-pass" autocomplete="off" />
		<br />
		<div id="sign-msg"></div>
		<br />
		<input type="submit" id="sign-submit" name="sign-submit" value="Log in"  />
	</form>
</div>
<?php
}
?>
