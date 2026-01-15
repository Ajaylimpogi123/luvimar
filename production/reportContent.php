<div class="box span10">
    <div class="box-header well" data-original-title>

        <?php
        $job1 = $conn->prepare("SELECT * FROM tbl_job_order WHERE is_deleted != '1' AND status = 'pending' ORDER BY date_added DESC");
        $job1->execute();
        $job1_data = $job1->fetch();

        ?>


        <h2><i class="icon-shopping-cart"></i> Production Report Content</h2>
    </div>

    <div class="box-content">
        <!-- Default Modals -->
        <!-- <div class="d-flex flex-wrap gap-2">
            <button id="openModalBtn">Open Modal</button>
        </div> -->
        <center>
            <h3>Job order number - <strong><?php echo $job1_data['job_order_number']; ?></strong></h3>
        </center>

        <form action="processAddPR.php" method="post">
            <?php

            $sql1 = $conn->prepare("SELECT * FROM tbl_pr_items WHERE is_deleted != '1' AND is_submitted != 1 ORDER BY pri_id DESC");
            $sql1->execute();

            if ($sql1->rowCount() > 0) {
            ?>
                <div class="cart_details"> <?php echo $sql1->rowCount(); ?> item(s)</div>
                <br />
                <table border="0" width="100%">
                    <tr>
                        <td width="100px;"><b>Customer</b></td>
                        <td width="10px;">&nbsp;</td>
                        <!-- <td width="100px;"><b>Product Name</b></td>
                        <td width="10px;">&nbsp;</td> -->
                        <td width="100px;"><b>Serial #</b></td>
                        <td width="10px;">&nbsp;</td>
                        <td width="100px;"><b>Qty</b></td>
                        <td width="10px;">&nbsp;</td>
                        <td width="150px;"><b>Price</b></td>
                        <td width="10px;">&nbsp;</td>
                        <td width="150px;"><b>Description</b></td>
                        <td width="10px;">&nbsp;</td>
                        <td width="150px;"><b>Partial Replacement</b></td>
                        <td width="10px;">&nbsp;</td>
                        <td width="100px;" align="center"><b>Remarks</b></td>
                        <td width="10px;">&nbsp;</td>
                        <td width="100px;" align="center"><b>Action</b></td>
                    </tr>
                    <?php

                    $total = 0;
                    while ($sql1_data = $sql1->fetch()) {
                        $total +=  $sql1_data['pr_qty'];
                        $br_id = $sql1_data['branch_id'];
                        $prId = $sql1_data['pd_id'];

                        $prd = $conn->prepare("SELECT * FROM tbl_product WHERE pd_id = '$prId'");
                        $prd->execute();
                        $prd_data = $prd->fetch();

                       $cus = $conn->prepare("SELECT * FROM bs_branch WHERE is_deleted != '1' AND branch_id = '$br_id' ORDER BY branch_name; ");
								$cus->execute();
                                $cus_data = $cus->fetch();
                    ?>




                        <tr>

                            <td><span class="border_cart"></span><?php echo $cus_data['branch_name']; ?></td>
                            <td width="10px;">&nbsp;</td>
                            <!-- <td><span class="border_cart"></span><?php echo $prd_data['pd_name']; ?></td>
                            <td width="10px;">&nbsp;</td> -->
                            <td><span class="border_cart"></span><input readonly name="pr_serial_<?php echo $prId; ?>[]" type="text" size="5" value="<?php echo $prd_data['pd_barcode']; ?>" class="box" style="width:100px;" autocomplete=off></td>
                            <td width="10px;">&nbsp;</td>
                            <td><span class="border_cart"><input readonly name="pr_qty_<?php echo $prId; ?>[]" type="text" size="5" value="<?php echo $sql1_data['pr_qty']; ?>" class="box" style="width:50px;" autocomplete=off>
                                </span></td>
                            <td width="10px;">&nbsp;</td>
                            <td><span class="border_cart"><input name="pr_price_<?php echo $prId; ?>[]" type="text" size="5" value="<?php echo $prd_data['pc_price']; ?>" class="box" style="width:50px;" autocomplete=off></span></td>
                            <td width="10px;">&nbsp;</td>
                            <input type="hidden" name="prdId[]" value="<?php echo $prId; ?>">

                            <td><span class="border_cart"><a href=""></a></span><?php echo $sql1_data['pr_description']; ?></td>

                            <td width="10px;">&nbsp;</td>
                            <td><span class="border_cart"></span><?php echo $sql1_data['part_replacement']; ?></td>
                            <td width="10px;">&nbsp;</td>
                            <td><span class="border_cart"></span><?php echo $sql1_data['pr_remarks']; ?></td>
                            <td width="10px;">&nbsp;</td>
                            <td><a class="btn btn-primary" href="index.php?view=modifyItems&uid=<?php echo $sql1_data['uid']; ?>"> <i class="icon-trash icon-white"></i>Modify</a></td>
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


            <?php

            $chk = $conn->prepare("SELECT * FROM tbl_pr_items WHERE is_deleted != '1'");
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


                <div class="control-group" style="display: flex; text-align:center; justify-content: center;">

                    <label class="control-label" for="focusedInput">Production Report Number: </label> &nbsp;
                    <input type="text" name="prNum" required>
                    <div id="status"></div>

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