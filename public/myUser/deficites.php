<?php
$deficits = getDeficits($_SESSION['hash']);
$total =0;
?>
<div class='basicPanel'/>
	<?php include '../../assets/showInfo.php'; ?>
	<?php if(isset($deficits) && count($deficits) > 0){ ?>
	<table border='1'>
		<tr><th>Purchase Date</th><th>Item Name</th><th>Cost</th></tr>
		<?php foreach($deficits as $d){
			$total += $d[1]; ?>
			<tr>
				<td><?php echo $d[2]; ?></td>
				<td><?php echo $d[0]; ?></td>
				<td><?php echo  "$".number_format($d[1], 2, '.', ''); ?></td>
			</tr>
		<?php } ?>
		<tr>
			<td></td>
			<td>Total</td>
			<td><?php echo  "$".number_format($total, 2, '.', ''); ?></td>
		</tr>
	</table>
<?php }else{ echo "No defficites found";} ?>
</div>

