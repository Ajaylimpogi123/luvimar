<!-- Modal -->
<div id="modal" class="modal">
    <div class="modal-content">
        <a href="#close" class="close-btn">&times;</a>

        <h2 class="modal-title">Add Expense Name</h2>
        <br>
        <form action="process.php?action=add_category" method="post">
            <div class="form-group">
                <label for="inputField">Expense Name</label>
                <input type="text" id="inputField" name="exp_name" placeholder="Enter expense name" required>
                
            </div>
            <div class="form-group">
              <label for="inputField">Details</label>
            <center><textarea name="details" id=""></textarea></center>
              
                
            </div>

            <div class="modal-actions">
                <button type="submit" class="action-btn">Submit</button>
            </div>
        </form>
    </div>
</div>