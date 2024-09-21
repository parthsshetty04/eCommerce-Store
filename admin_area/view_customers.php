<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
?>

<div class="row"><!-- 1 row Starts -->
    <div class="col-lg-12"><!-- col-lg-12 Starts -->
        <ol class="breadcrumb"><!-- breadcrumb Starts  --->
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / View Orders
            </li>
        </ol><!-- breadcrumb Ends  --->
    </div><!-- col-lg-12 Ends -->
</div><!-- 1 row Ends -->


<div class="row"><!-- 2 row Starts -->
    <div class="col-lg-12"><!-- col-lg-12 Starts -->
        <div class="panel panel-default"><!-- panel panel-default Starts -->
            <div class="panel-heading"><!-- panel-heading Starts -->
                <h3 class="panel-title"><!-- panel-title Starts -->
                    <i class="fa fa-money fa-fw"></i> View Orders
                </h3><!-- panel-title Ends -->
            </div><!-- panel-heading Ends -->
            <div class="panel-body"><!-- panel-body Starts -->
                <div class="table-responsive"><!-- table-responsive Starts -->
                    <table class="table table-bordered table-hover table-striped"><!-- table table-bordered table-hover table-striped Starts -->
                        <thead><!-- thead Starts -->
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Invoice</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Size</th>
                                <th>Order Date</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Total Purchases</th> <!-- New Column -->
                            </tr>
                        </thead><!-- thead Ends -->
                        <tbody><!-- tbody Starts -->
                            <?php
                            $i = 0;
                            $get_orders = "SELECT c.customer_email, po.invoice_no, p.product_title, po.qty, po.size, co.order_date, co.due_amount, po.order_status, COUNT(co.order_id) AS total_purchases
                                           FROM customers c
                                           LEFT JOIN customer_orders co ON c.customer_id = co.customer_id
                                           LEFT JOIN pending_orders po ON co.order_id = po.order_id
                                           LEFT JOIN products p ON po.product_id = p.product_id
                                           GROUP BY c.customer_id";
                            $run_orders = mysqli_query($con, $get_orders);
                            while ($row_orders = mysqli_fetch_array($run_orders)) {
                                $customer_email = $row_orders['customer_email'];
                                $invoice_no = $row_orders['invoice_no'];
                                $product_title = $row_orders['product_title'];
                                $qty = $row_orders['qty'];
                                $size = $row_orders['size'];
                                $order_date = $row_orders['order_date'];
                                $due_amount = $row_orders['due_amount'];
                                $order_status = $row_orders['order_status'];
                                $total_purchases = $row_orders['total_purchases'];
                                $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $customer_email; ?></td>
                                <td><?php echo $invoice_no; ?></td>
                                <td><?php echo $product_title; ?></td>
                                <td><?php echo $qty; ?></td>
                                <td><?php echo $size; ?></td>
                                <td><?php echo $order_date; ?></td>
                                <td>$<?php echo $due_amount; ?></td>
                                <td><?php echo ($order_status == 'pending') ? '<div style="color:red;">Pending</div>' : 'Completed'; ?></td>
                                <td>
                                    <a href="index.php?order_delete=<?php echo $order_id; ?>">
                                        <i class="fa fa-trash-o"></i> Delete
                                    </a>
                                </td>
                                <td><?php echo $total_purchases; ?></td> <!-- Displaying Total Purchases -->
                            </tr>
                            <?php } ?>
                        </tbody><!-- tbody Ends -->
                    </table><!-- table table-bordered table-hover table-striped Ends -->
                </div><!-- table-responsive Ends -->
            </div><!-- panel-body Ends -->
        </div><!-- panel panel-default Ends -->
    </div><!-- col-lg-12 Ends -->
</div><!-- 2 row Ends -->
<?php } ?>
