<?php
session_start();
session_id();
include('../tmp_dsh2/header.php');
include('navbar.php');
include('menu.php');
include('../config/config.php');
?>
<div class="container-fluid">
	<h1 class="display-3">จ่ายเงินฝากสัจจะ</h1>
	<form class="control-row " action="dep-pay-login.php" method="POST">
		<select name="employee_USER" class="form-control-lg col-12 mb-2">
			<?php
			$sql = "SELECT * from employee ORDER BY Username ASC ";
			$query = mysqli_query($link, $sql);
			while ($rs1 = mysqli_fetch_array($query)) {
				$Username = $rs1['Username'];
				$FullNameEmp = $rs1['Firstname'] . " " . $rs1['Lastname'];

			?>
				<option value="<?php echo $Username; ?>">
						<?php echo $Username . " [" . $FullNameEmp . "]" ?>
				</option>
			<?php
			}
			?>
		</select>

		<button type="submit" class="btn btn-primary   btn-lg btn-block">
			<h3>
				จ่ายเงินสัจจะ + พชพ
			</h3>
		</button>
	</form>
</div>
<?PHP
include('../tmp_dsh2/table.php');
include('../tmp_dsh2/footer.php');
?>