<?php
if (!defined('WEB_ROOT')) {
    exit;
}
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
$user = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId'");
$user->execute();
$user_data = $user->fetch();

$sql = $conn->prepare("SELECT * FROM tr_expense_category WHERE is_deleted != '1' ORDER BY date_added");
$sql->execute();
?>
<style>
    /* Open Button */
    .open-btn {
        display: inline-block;
        padding: 10px 18px;
        background: #0d6efd;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
    }

    /* Modal Background */
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 140%;
        height: 160%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
        z-index: 999;
    }

    /* Show Modal */
    .modal:target {
        opacity: 1;
        pointer-events: auto;
    }

    /* Modal Box */
    .modal-content {
        background: #fff;
        padding: 25px;
        width: 350px;
        border-radius: 10px;
        position: relative;
        text-align: center;
        animation: scaleIn 0.3s ease;
    }

    /* Animation */
    @keyframes scaleIn {
        from {
            transform: scale(0.9);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Close Button */
    .close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 22px;
        text-decoration: none;
        color: #555;
    }

    .close-btn:hover {
        color: #000;
    }

    /* Action Button */
    .action-btn {
        margin-top: 20px;
        padding: 10px 18px;
        border: none;
        background: #198754;
        color: #fff;
        border-radius: 6px;
        cursor: pointer;
        font-size: 15px;
    }

    .action-btn:hover {
        background: #157347;
    }
</style>
<!-- Open Modal Button -->
<a href="#modal" class="btn btn-success">Add Expense Name</a>
<!-- <a href="index.php?view=cat" class="open-btn">Add Category Expense</a> -->
<!-- Dummy target to close modal -->
<div id="close"></div>

<?php
include 'add_category.php';
?>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header well" data-original-title>
            <h2><i class="icon-plus-sign"></i> Expense Name</h2>
        </div>
        <div class="box-content">
            <table class="table table-striped table-bordered bootstrap-datatable datatable">
                <thead>
                    <tr>
                        <th>Expense Name</th>
                        <th>Details</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($sql->rowCount() > 0) {
                        while ($sql_data = $sql->fetch()) {
                            $addeddate = date("M d, Y | h:i a", strtotime($sql_data['date_added']));
                            $ec_id = $sql_data['ec_id'];
                    ?>
                            <!-- Start display list of expenses !-->
                            <tr>

                                <td><?php echo $sql_data['expense_category_name']; ?></td>
                                <td><?php echo $sql_data['cat_details']; ?></td>
                                <td class="center">
                                    <?php if ($user_data['is_exp_e_access'] == 1) { ?>
                                        <a class="btn btn-primary" href="#<?php echo $ec_id; ?>">
                                            <i class="icon-edit icon-white"></i>
                                            Edit
                                        </a>
                                    <?php } else {
                                        echo "-- --";
                                    } ?>
                                    <?php if ($user_data['is_exp_d_access'] == 1) { ?>
                                        <a class="btn btn-danger" onclick="return confirmDelete1()" href="process.php?action=cat_delete&id=<?php echo $sql_data['ec_id']; ?>">
                                            <i class="icon-trash icon-white"></i>
                                            Delete
                                        </a>
                                    <?php } else {
                                        echo "-- --";
                                    } ?>
                                </td>
                            </tr>
                            <!-- End display list of expenses !-->


                    <?php
                            include 'edit_category.php';
                        }
                    } else {
                    }
                    ?>

                </tbody>
            </table>


        </div>
    </div>
</div><!--/span-->
<script>
    function confirmDelete1() {
        return confirm("Are you sure do you want to Delete?");
    }
</script>