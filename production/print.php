<?php
// Start output buffering
ob_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../global-library/config.php';
require_once '../global-library/database.php';
require_once('../tcpdf/tcpdf.php');

$prId = isset($_GET['prId']) ? intval($_GET['prId']) : 0;

if ($prId) {
    $sql = $conn->prepare("SELECT * FROM tbl_production_report WHERE pr_id = :prId");
    $sql->execute([':prId' => $prId]);

    if ($sql->rowCount() > 0) {

        $sql_data = $sql->fetch();
        $joId     = $sql_data['jo_id'];
        $added_by = $sql_data['added_by']; // ✅ Save BEFORE the while loop, never overwrite

        $jo = $conn->prepare("SELECT * FROM tbl_job_order WHERE jo_id = :joId AND is_deleted != '1'");
        $jo->execute([':joId' => $joId]);
        $jo_data      = $jo->fetch();
        $Job_order_no = $jo_data['job_order_number'];

        // Create PDF
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('LUVIMAR FIRE CONTROL AVENUE');
        $pdf->SetTitle('Production Report Slip');
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(TRUE, 10);
        $pdf->AddPage();

        $company_logo = '../images/branch_logo/main.png';
        if (file_exists($company_logo)) {
            $pdf->Image($company_logo, 30, 25, 30, 30, '', '', '', false, 300, '', false, false, 0, false, false, false);
        }

        $html = '
        <style>
            table { border-collapse: collapse; width: 100%; }
            table, th { border: 1px solid #000; padding: 4px; }
            td { border: 1px solid #000; padding: 4px; font-size: 10px; }
            .header { text-align: center; font-size: 10px; margin-bottom: 3px; }
        </style>
        <div class="header">
            <h3>LUVIMAR FIRE CONTROL AVENUE</h3>
            <p>Terra Plaza, Cor. Rizal - Gatuslao Sts., Bacolod City</p>
            <p>Tel. Nos: 476-2612 / 708-6185 / 213-2714</p>
            <p>Mobile Nos: 0949-3934805 / 0912-5374747</p>
            <strong>PRODUCTION REPORT</strong> - <strong>No. ' . $Job_order_no . '</strong>
        </div>
        <br>
        <table>
            <tr>
                <th>DATE</th>
                <th style="width: 10%">REF J.O #</th>
                <th style="width: 15%">CUSTOMER</th>
                <th style="width: 10%">QTY</th>
                <th>DESCRIPTION</th>
                <th style="width: 15%">PARTS REPLACEMENT</th>
                <th>Serial # <p style="font-size: 6px">Note: To be Filled-up by office staff</p></th>
                <th>REMARKS</th>
            </tr>
        ';

        // ✅ Fetch from tbl_pr_list — includes pr_serial saved during processAddPR
        $prl = $conn->prepare("
            SELECT 
                prl.pr_date_added,
                prl.pr_serial,       
                prl.pd_id,
                pri.pr_qty,
                pri.pr_description,
                pri.part_replacement,
                pri.pr_remarks,
                brn.branch_name
            FROM tbl_pr_list prl
            JOIN tbl_pr_items pri ON pri.pri_id = prl.pri_id
            JOIN bs_branch brn    ON brn.branch_id = prl.branch_id
            JOIN bs_user us       ON us.user_id = prl.user_id
            WHERE prl.pr_id = :prId
              AND pri.is_submitted = '1'
        ");
        $prl->execute([':prId' => $prId]);

        while ($prl_data = $prl->fetch()) {
            $date             = $prl_data['pr_date_added'];
            $branchName       = $prl_data['branch_name'];
            $qty              = $prl_data['pr_qty'];
            $pr_description   = $prl_data['pr_description'];
            $part_replacement = $prl_data['part_replacement'];
            $remarks          = $prl_data['pr_remarks'];

            // ✅ Read pr_serial from tbl_pr_list (comma-separated barcodes)
            $serial = $prl_data['pr_serial'];

            // ✅ Display each barcode on its own line in the PDF
            $serialFormatted = !empty($serial)
                ? implode('<br>', array_map('trim', explode(',', $serial)))
                : '-';

            $html .= '
            <tr>
                <td>' . date("F j, Y", strtotime($date)) . '</td>
                <td>' . $Job_order_no . '</td>
                <td>' . $branchName . '</td>
                <td>' . $qty . '</td>
                <td>' . $pr_description . '</td>
                <td>' . $part_replacement . '</td>
                <td>' . $serialFormatted . '</td>
                <td>' . $remarks . '</td>
            </tr>
            ';
        }

        $html .= '</table>';

        // ✅ Use $added_by from tbl_production_report (never overwritten)
        $user = $conn->prepare("SELECT * FROM bs_user WHERE user_id = :added_by");
        $user->execute([':added_by' => $added_by]);
        $user_data = $user->fetch();
        $firstname = $user_data['firstname'] ?? 'N/A';

        $html .= '
        <br><br>
        <table style="width:100%; margin-top:30px; text-align:center; border-collapse:collapse; font-size:12px; border:none;">
            <tr>
                <td style="width:25%; border:none;">
                    <strong>Job done By: ' . $firstname . '</strong><br><br>
                    <div style="border-top:1px solid #000; width:80%; margin:0 auto;"></div>
                    <div>Secretary</div>
                </td>
                <td style="width:25%; border:none;">
                    <strong>Checked By:</strong><br><br>
                    <div style="border-top:1px solid #000; width:auto; margin:0 auto;"></div>
                    <div>Shop Supervisor</div>
                </td>
                <td style="width:25%; border:none;">
                    <strong>Received By:</strong><br><br>
                    <div style="border-top:1px solid #000; width:80%; margin:0 auto;"></div>
                    <div>Office Secretary</div>
                </td>
                <td style="width:25%; border:none;">
                    <strong>Approved By:</strong><br><br>
                    <div style="border-top:1px solid #000; width:80%; margin:0 auto;"></div>
                    <div>Manager</div>
                </td>
            </tr>
        </table>
        ';

        $pdf->writeHTML($html, true, false, true, false, '');

        ob_end_clean();
        $pdf->Output('joborder_' . $Job_order_no . '.pdf', 'I');

    } else {
        echo "Job order not found.";
    }
} else {
    echo "Invalid ID.";
}