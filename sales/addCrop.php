<!-- Modal -->
<div class="modal fade" id="<?php echo $prdId; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel"><?php echo $prdName; ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="text-align: center;">
                <form action="index.php" method="post" name="frm" id="frm">

                    <tr>
                        <td colspan="3">
                            <hr color="black" size="4" />
                        </td>
                    </tr>
                    <tr>
                        <td><span class="blue" style="font-size:37px; font-weight:bold;">Qty</span></td>
                        <td>&nbsp; &nbsp;</td>
                        <td>
                            <input name="qty" type="number" id="qty" size="30" maxlength="50" style="font-size:47px; font-weight:bold; width:100px; height:70px;" onKeyUp="checkNumber(this);" required autocomplete=off />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <hr color="black" size="4" />
                        </td>
                    </tr>
                    <tr>


                        <input type="hidden" name="pid" value="<?php echo $prdId; ?>" />
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="hidden" name="mid" value="<?php echo $mid; ?>" />
                        <td colspan="3"><input type="submit" name="submit" value="Submit" class="btn btn-large btn-info"></td>
                    </tr>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.END modal -->