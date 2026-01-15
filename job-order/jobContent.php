<div class="box span7">
    <div class="box-header well" data-original-title>
        <h2><i class="icon-shopping-cart"></i> Job Order Content</h2>
    </div>

    <div class="box-content">
        <?php
        $sql1 = $conn->prepare("SELECT * FROM tbl_jo_items WHERE is_deleted != '1' AND is_submitted != 1 ORDER BY joi_id DESC");
        $sql1->execute();

        if ($sql1->rowCount() > 0) {
        ?>
            <div class="cart_details"> <?php echo $sql1->rowCount(); ?> item(s)</div>
            <br />
            <table border="0" width="100%">
                <tr>
                    <td width="100px;"><b>Customer</b></td>
                    <td width="10px;">&nbsp;</td>
                    <td width="100px;"><b>qty</b></td>
                    <td width="10px;">&nbsp;</td>
                    <td width="150px;"><b>Description</b></td>
                    <td width="10px;">&nbsp;</td>
                    <td width="150px;"><b>Job Description</b></td>
                    <td width="10px;">&nbsp;</td>
                    <td width="150px;"><b>Date Needed</b></td>
                    <td width="10px;">&nbsp;</td>
                    <td width="100px;" align="center"><b>Remarks</b></td>
                    <td width="10px;">&nbsp;</td>
                    <td width="100px;" align="center"><b>Action</b></td>
                </tr>
                <?php

                $total = 0;
                while ($sql1_data = $sql1->fetch()) {
                    $total +=  $sql1_data['qty'];
                    $pdId = $sql1_data['pd_id'];

                    $prd = $conn->prepare("SELECT * FROM tbl_product WHERE pd_id = '$pdId'");
                    $prd->execute();
                    $prd_data = $prd->fetch();
                    $pd_name = $prd_data['pd_name'];


                ?>



                    <tr>

                        <td><span class="border_cart"></span><?php echo word_split($sql1_data['customer_name'], 2); ?></td>
                        <td width="10px;">&nbsp;</td>
                        <td><span class="border_cart"></span><?php echo $sql1_data['qty']; ?></td>
                        <td width="10px;">&nbsp;</td>

                        <td><span class="border_cart"></span><?php echo $sql1_data['description']; ?></td>
                        <td width="10px;">&nbsp;</td>
                        <td><span class="border_cart"></span><?php echo $sql1_data['job_description']; ?></td>
                        <td width="10px;">&nbsp;</td>
                        <td><span class="border_cart"></span><?php echo date("F j, Y", strtotime($sql1_data['date_needed'])); ?></td>
                        <td width="10px;">&nbsp;</td>
                        <td><span class="border_cart"></span><?php echo $sql1_data['remarks']; ?></td>
                        <td width="10px;">&nbsp;</td>
                        <td><a class="btn btn-danger" href="processDelete.php?uid=<?php echo $sql1_data['uid']; ?>"> <i class="icon-trash icon-white"></i>Delete</a></td>
                        <td width="10px;">&nbsp;</td>

                    </tr>
                <?php
                } // End For

                ?>
                <tr>
                    <td colspan="9">
                        <hr style="border: 0; height: 1px; background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0));  background-image: -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); " />
                    </td>
                </tr>
                <tr>
                    <td><span class="border_cart"></span>Total Qty:</td>
                    <td></td>
                    <td><span class="border_cart"></span> <?php echo $total; ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
            </table>

        <?php
        } else {
            echo "Job order Is Empty";
        }
        ?>

        <form action="processAddJobOrder.php" method="post">
            <?php

            $chk = $conn->prepare("SELECT * FROM tbl_jo_items WHERE is_deleted != '1'");
            $chk->execute();
            $rows = $chk->fetchAll();

            $disabled = true;

            foreach ($rows as $row) {
                $row = $row['is_submitted'];
                if ($row == 0) {
                    $disabled = false;
                    break;
                }
            }

            if ($disabled) {
            ?>
                <!-- show is_submitted = 0 -->
                <div style="display: flex; text-align:center; justify-content: center;">
                    <input type="submit" class="btn btn-primary" value="Submit Request" disabled>
                </div>
            <?php
            } else {
            ?>


                <div style="display: flex; text-align:center; justify-content: center;">
                    <label for="">Job Order Number: </label>
                    <input type="text" name="job_number" required>
                </div>

                <div style="display: flex; text-align:center; justify-content: center;">
                    <input type="submit" onclick="return confirmDelete()" class="btn btn-primary" value="Submit Request">
                </div>
            <?php
            }

            ?>
        </form>
        <script>
            function confirmDelete() {
                return confirm("Are you sure do you want to add Job Order?");
            }
        </script>

    </div>
</div>