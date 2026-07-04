<?php
if (!defined('WEB_ROOT')) {
    exit;
}
// make sure a id exists
if (isset($_GET['uid']) && $_GET['uid'] > 0) {
    $uid = $_GET['uid'];
} else {
    // redirect to index.php if id is not present
    header('Location: index.php');
}

/* Select book from database */
$sql = $conn->prepare("SELECT * FROM tbl_pr_items WHERE uid = '$uid' AND is_deleted != '1'");
$sql->execute();
$sql_data = $sql->fetch();
$pd_Id = $sql_data['pd_id'];


$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'

?>

<?php
if ($errorMessage == 'Modified successfully') {
?>
    <div class="valid_box">
        <b><?php echo $errorMessage; ?></b>
    </div>
<?php
} else if ($errorMessage == 'Product already exist! Data entry failed.') {
?>
    <div class="error_box">
        <b><?php echo $errorMessage; ?></b>
    </div>
<?php
} else if ($errorMessage == 'Image deleted successfully') {
?>
    <div class="valid_box">
        <b><?php echo $errorMessage; ?></b>
    </div>
<?php
} else {
}
?>
<div class="row-fluid sortable">
    <div class="box span8">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-edit"></i> Modify Item in Production</h2>
        </div>

        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="processModifyItems.php">
            <div class="box-content">

                <fieldset>

                    <div id="refill" class="control-group">
                        <label class="control-label" for="focusedInput">Product Name</label>
                        <div class="controls">
                     
                     <?php
                     $prd = $conn->prepare("SELECT * FROM tbl_product WHERE is_deleted != '1' AND pd_id = '$pd_Id'");
                     $prd->execute();
                       $prd_data = $prd->fetch();
                     ?>

                             <input readonly class="input-xlarge focused" name="pdId" id="barcode"type="text" value="<?php echo $prd_data['pd_name']; ?>" />
                  <?php
                    
                     ?>
             
             </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="focusedInput">Qty</label>
                        <div class="controls">
                            <input class="input-xlarge focused" id="barcode" name="qty" type="text" value="<?php echo $sql_data['pr_qty']; ?>" />
                            <div id="status"></div>
                        </div>
                    </div>
                    <!-- <div class="control-group">
                        <label class="control-label" for="focusedInput">Serial Number</label>
                        <div class="controls">

                            <?php

                            $prId = $sql_data['pd_id'];

                            $prd = $conn->prepare("SELECT * FROM tbl_product WHERE pd_id = '$prId'");
                            $prd->execute();
                            $prd_data = $prd->fetch();
                            ?>
                            <input class="input-xlarge focused" id="barcode" name="barcode" type="text" value="<?php echo $sql_data['pr_serial']; ?>" />
                            <div id="status"></div>
                        </div>
                    </div> -->

                    <div class="control-group">
                        <label class="control-label" for="focusedInput">Product Price</label>
                        <div class="controls">
                            <input class="input-xlarge focused" id="pdname" name="pr_price" type="text" value="<?php echo $sql_data['pr_price']; ?>" autocomplete=off required />
                            <div id="status"></div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="focusedInput">Production Description</label>
                        <div class="controls">
                            <textarea id="description" name="pr_description"><?php echo $sql_data['pr_description']; ?></textarea>
                            <div id="status"></div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="focusedInput">Parts Replacement</label>
                        <div class="controls">
                            <textarea id="description" name="part_replacement"><?php echo $sql_data['part_replacement']; ?></textarea>
                            <div id="status"></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="focusedInput">Production Remarks</label>
                        <div class="controls">
                            <textarea id="description" name="pr_remark"><?php echo $sql_data['pr_remarks']; ?></textarea>
                            <div id="status"></div>
                        </div>
                    </div>


                </fieldset>
            </div>
            <div class="form-actions">
                <input type="hidden" name="uid" value="<?php echo $sql_data['uid']; ?>" />
                <button type="submit" class="btn btn-success">Save Changes</button>
            </div>
        </form>
    </div>


</div><!--/span-->