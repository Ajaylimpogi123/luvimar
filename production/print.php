<?php
// Start output buffering
ob_start();

// Display all errors (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include required files
require_once '../global-library/config.php';
require_once '../global-library/database.php';
require_once('../tcpdf/tcpdf.php');

// Get job order ID
$prId = isset($_GET['prId']) ? intval($_GET['prId']) : 0;

if ($prId) {
    // Fetch order data
    $sql = $conn->prepare("SELECT * FROM tbl_production_report WHERE pr_id = '$prId'");
    $sql->execute();


    if ($sql->rowCount() > 0) {

        $sql_data = $sql->fetch();
        $joId = $sql_data['jo_id'];

        $jo = $conn->prepare("SELECT * FROM tbl_job_order WHERE jo_id = '$joId' AND is_deleted != '1'");
        $jo->execute();
        $jo_data = $jo->fetch();
        $Job_order_no = $jo_data['job_order_number'];

        $added_by = $sql_data['added_by'];
        // Create new PDF document
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);


        // remove default header/footer
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


        // Build HTML
        $html = '
        <style>
            table { border-collapse: collapse; width: 100%; }
            table, th { border: 1px solid #000; padding: 4px; }
            td { border: 1px solid #000; padding: 4px;  font-size: 10px;}
            .header { text-align: center; font-size: 10px; margin-bottom: 3px; }
        </style>
        <div class="header">
            <h3>LUVIMAR FIRE CONTROL AVENUE</h3>
            <p>Terra Plaza, Cor. Rizal - Gatualas Sts., Bacolod City</p>
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


        $prl = $conn->prepare("SELECT * FROM tbl_pr_list prl, tbl_pr_items pri, tbl_job_order jo, bs_branch brn, bs_user us WHERE 
         prl.pr_id = '$prId' AND pri.pri_id = prl.pri_id AND prl.branch_id = brn.branch_id AND prl.user_id = us.user_id AND pri.is_submitted = '1'");
        $prl->execute();

        $counter = 1;
        $total = 0;


        while ($prl_data = $prl->fetch()) {
            $date = $prl_data['pr_date_added'];
            $branchName = $prl_data['branch_name'];
            $qty = $prl_data['pr_qty'];
            $pr_description = $prl_data['pr_description'];
            $part_replacement = $prl_data['part_replacement'];
            $serial = $prl_data['pr_serial'];
            $remarks = $prl_data['pr_remarks'];

            // Example static row (replace with actual DB query if needed)
            $html .= '
            <tr>
                <td> ' . date("F j, Y", strtotime($date)) . '</td>
                <td> ' . $Job_order_no . ' </td>
                <td> ' . $branchName . ' </td>
                <td>' . $qty . '</td>
                <td>' . $pr_description . '</td>
                <td>' . $part_replacement . '</td>
                <td>' .  $serial . '</td>
                <td>' . $remarks . '</td>
            </tr>
        ';
        };
        $html .= '</table>';

        $user = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$added_by'");
        $user->execute();
        $user_data = $user->fetch();
        $firstname = $user_data['firstname'];

        // Signature section
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

        // Write HTML to PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output PDF
        ob_end_clean();
        $pdf->Output('joborder_' . $Job_order_no . '.pdf', 'I');
    } else {
        echo "Job order not found.";
    }
} else {
    echo "Invalid ID.";
}
