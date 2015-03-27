<?php
	include_once('../../include/functions.php');


	if(isset($_POST['table'])) {
		$select = '';
		foreach($_POST['col'][0] as $index => $value) {
			$select .= "`" .$index. "`,";
		}
		$select = substr($select, 0, -1);

		$query = "SELECT * FROM ".$_POST['table'].$_POST['where']."";
		//echo $query;
		$valueOBJ = $obj->query_db($query);


	}
?>
<style type="text/css">

  .tip .btn {
    width: 28%;
    padding: -4px;
  }
</style>
<script type="text/javascript">
	$(document).ready(function(){
		<?php
			if($_POST['actualTable'] == "staff_order") {
				echo "$('.data_table2').dataTable();\n";
			} else {
		?>
		$('.data_table2').dataTable({
			"sPaginationType": "full_numbers"
		});
		<?php
			}
		?>
		$(".dataTables_wrapper .dataTables_length select").addClass("small");
		$(function() {
			$('select').not("select.chzn-select,select[multiple],select#box1Storage,select#box2Storage").selectmenu({
				style: 'dropdown',
				transferClasses: true,
				width: null
			});
		});
	});
</script>

<table class="display data_table2" >
	<thead>
		<tr>
			<?php
				foreach($_POST['col'][0] as $value) {
					echo '<th>'.$value.'</th>';
				}
			?>
			<?php
				if($_POST['actualTable']  != 'staff_order') {
			?>
			<th width="50">Action</th>
			<?php
				}
			?>
		</tr>
	</thead>
	<tbody>
		<?php
			while($array = $obj->fetch_db_array($valueOBJ)) {
		?>
		<tr>
			<?php

				foreach($_POST['col'][0] as $key => $value) {
					switch($key) {
						case 'slider_picture' :
							echo '<td><a href="../items-pictures/'.$array[$key].'" target="_blank"><img src="../items-pictures/'.$array[$key].'" style="width:50px; height:50px;"></a></td>';
							break;
						case 'item_picture':
							echo '<td><a href="../items-pictures/'.$array[$key].'" target="_blank"><img src="../items-pictures/'.$array[$key].'" style="width:50px; height:50px;"></a></td>';
							break;
						case 'order_details':
							echo '<td align="left" width="380px">';
									
							$arrayValue = json_decode($array[$key]);
								$tcount = 0;
									foreach($arrayValue as $ID => $IDValue) {
										if($ID != 'TOTAL'){
											echo '<div class="order_details">';
											
											foreach($IDValue as $c =>  $items) {
												if($c == 'TOTAL') {
													$items = ' &pound;'.$items;
												}
												echo '<strong> '.$c.'</strong> : '.$items;
												
											}
											echo '</div>';
										}
										$tcount ++;
									}
							echo '<div style="text-align:right">Total Items: '.($tcount-1).'</div>';
							echo '</td>';
							break;
						case 'order_total':
							echo '<td>&pound;'.$array[$key].'</td>';
							break;
						case 'order_user_id':
							echo '<td>ID-'.$array[$key].'</td>';
							break;
						case 'order_id':
							echo '<td>Order ID-'.$array[$key].'</td>';
							break;
						case 'id':
							echo '<td>ID-'.$array[$key].'</td>';
							break;
						case ($key == 'staff_postcode' || $key == 'order_postcode'):
							$Arr = json_decode($array[$key],true);
							echo '<td>'.key($Arr).'</td>';
							break;
						case ($key == 'f_feed' || $key == 'f_order'):
							echo '<td width="190px" align="left">'.$array[$key].'</td>';
							break;
						default:
							echo '<td>'.$array[$key].'</td>';
					}
				}

			?>
			<?php
				if($_POST['actualTable']  != 'staff_order') {
			?>
		  <div>
        <td>
          <?php if($_POST['actualTable'] != 'orders') {?>
            <span class="tip" >
					<a href="<?php echo $_POST['editURL'].$array[$_POST['delColumn']]?>" title="Edit">
            <button class="btn btn-info" type="button"><i class="glyphicon glyphicon-edit"></i></button>
          </a>
				</span>
          <?php } ?>
          <span class="tip" >
					<a id="<?php echo $array[$_POST['delColumn']]?>" class="Delete"  name="<?php echo $array[1]?>" title="Delete" rel="<?php echo $_POST['actualTable']?>/<?php echo $_POST['delColumn']?>">
            <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-trash"></i></button>
          </a>
				</span>
        </td>
		  </div>
			<?php
				}
			?>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>
