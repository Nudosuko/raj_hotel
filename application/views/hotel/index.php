<?php
    session_start();
?>
<style>
    .order-card {
        background-color: #fff;
        border-radius: 10px;
        border: 1px solid #ddd;
        padding: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); /* Soft Shadow */
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2); /* Stronger Shadow on Hover */
    }

    .table-number {
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }

    .total-amount {
        font-size: 20px;
        font-weight: bold;
        color: #28a745;
    }

    .btn-group a {
        width: 100%;
        margin: 5px 0;
    }

    .no-order {
        font-size: 14px;
    }
</style>

<div class="container">
	<div class="row">
		<?php
			foreach ($tables as $row) {
				$sql="SELECT *,
				 	(SELECT SUM(total) FROM order_product 
				 		WHERE order_product.order_id = order_tbl.order_id)
				 		 as ttl 
				 	FROM order_tbl 
				 		WHERE order_status='active' AND table_id ='".$row['table_id']."';";

			$orders = $this->db->query($sql)->result_array();
		?>
		<div class="col-md-3 mt-5">
    <div class="order-card p-3 text-center">
        <h5 class="table-number">Table No: <?=$row['table_no']?></h5>
        <hr>
        <?php if(isset($orders[0]['ttl'])) { ?>
            <h4 class="total-amount">&#8377; <?=$orders[0]['ttl']?></h4>
            <div class="btn-group mt-2">
                <a href="<?=base_url()?>hotel/order_details/<?=$orders[0]['order_id']?>" class="btn btn-sm btn-primary">Order Details</a>
                <a href="<?=base_url()?>hotel/print_bill/<?=$orders[0]['order_id']?>" class="btn btn-sm btn-dark">Print Bill</a>
            </div>
        <?php } else { ?>
            <p class="text-muted no-order">No Active Order</p>
        <?php } ?>
    </div>
</div>
		<?php	
			}
		?>
	</div>
</div>


<br><br><br><br>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<canvas id="myChart" style="width:100%;max-width:800px; margin-left: 20%; text-align: center;"></canvas>
<?php 
	// echo"<pre>";
	// 	print_r($x_axis);
	// 	print_r($y_axis);
	// echo"</pre>";
 ?>
<script>
var xValues = [<?= "'".implode("', '",$x_axis)."'"?>]; //for dates
var yValues = [0,<?= "'".implode("', '",$y_axis)."'"?>]; //for amount
var barColors = ["red", "green","blue","orange","brown"];

new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: 'red',
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Last 7 Days Sell =  ₹ <?= number_format(array_sum($y_axis))?>"
    }
  }
});
</script>


<br><br><br><br><br><br><br><br>