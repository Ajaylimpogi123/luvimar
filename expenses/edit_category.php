<!-- Modal -->
<div id="<?php echo $ec_id; ?>" class="modal">
    <div class="modal-content">
        <a href="#close" class="close-btn">&times;</a>

        <h2 class="modal-title">Modify</h2>
        <br>
        <?php
        $mod = $conn->prepare("SELECT * FROM tr_expense_category WHERE is_deleted != 1");
        $mod->execute();
        $mod_data = $mod->fetch();

        ?>
        <form action="process.php?action=cat_modify&id=<?php echo $ec_id; ?>" method="post">
            <div class="form-group">
                <label for="inputField">Expense Name</label>
                <input type="text" id="inputField" value="<?php echo $mod_data['expense_category_name'] ?>" name="cat_name" placeholder="Enter expense name" required>

            </div>
            <div class="form-group">
                <label for="inputField">Details</label>
                <center><textarea name="details" value="<?php echo $mod_data['cat_details']; ?> " id=""></textarea></center>


            </div>

            <div class="modal-actions">
                <button type="submit" class="action-btn">Submit</button>
            </div>
        </form>
    </div>
</div>