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
$joId = isset($_GET['joId']) ? intval($_GET['joId']) : 0;

if ($joId) {
    // Fetch order data
    $sql = $conn->prepare("SELECT * FROM tbl_job_order WHERE jo_id = '$joId'");
    $sql->execute();

    if ($sql->rowCount() > 0) {

        $sql_data = $sql->fetch();
        $Job_order_no = $sql_data['job_order_number'];
        $added_by = $sql_data['added_by'];
        // Create new PDF document
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);


        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('LUVIMAR FIRE CONTROL AVENUE');
        $pdf->SetTitle('Job Order Slip');
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
            table { border-collapse: collapse; width: 100%;  }
            table, th { border: 1px solid #000; padding: 4px; }
                 td { border: 1px solid #000; padding: 4px;  font-size: 10px;}
            .header { text-align: center; font-size: 11px; margin-bottom: 3px; }
        </style>
        <div class="header">
            <h3>LUVIMAR FIRE CONTROL AVENUE</h3>
            <p>Terra Plaza, Cor. Rizal - Gatualas Sts., Bacolod City</p>
            <p>Tel. Nos: 476-2612 / 708-6185 / 213-2714</p>
            <p>Mobile Nos: 0949-3934805 / 0912-5374747</p>
            <strong>JOB ORDER SLIP</strong> - <strong>No. ' . $Job_order_no . '</strong>
        </div>
        <br>
        <table>
            <tr>
                <th>DATE</th>
                <th>CUSTOMER</th>
                <th>QTY</th>
                <th>DESCRIPTION</th>
                <th>JOB DESCRIPTION (BN / REF)</th>
                <th>DATE NEEDED</th>
                <th>REMARKS</th>
            </tr>
        ';


        $jol = $conn->prepare("SELECT * FROM tbl_jo_list jol, tbl_jo_items joi,  bs_customer cus, bs_user us 
        WHERE jol.jo_id = '$joId' AND joi.joi_id = jol.joi_id  AND jol.user_id = us.user_id AND cus.cust_id = joi.cust_id AND joi.is_submitted = '1'");
        $jol->execute();

        $counter = 1;
        $total = 0;


        while ($jol_data = $jol->fetch()) {
            $date = $jol_data['joi_date_added'];
            $custName = $jol_data['client_name'];
            $qty = $jol_data['qty'];
            $decription = $jol_data['description'];
            $jo_decription = $jol_data['job_description'];
            $date_needed = $jol_data['date_needed'];
            $remarks = $jol_data['remarks'];

            // Example static row (replace with actual DB query if needed)
            $html .= '
            <tr>
                <td> ' . date("F j, Y", strtotime($date)) . '</td>
                <td> ' . $custName . ' </td>
                <td>' . $qty . '</td>
                <td>' . $decription . '</td>
                <td>' . $jo_decription . '</td>
                <td>' .  date("F j, Y", strtotime($date_needed)) . '</td>
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
                <td style="width:33%; border:none;">
                    <strong>Requested By: ' . $firstname . '</strong><br><br>
                    <div style="border-top:1px solid #000; width:80%; margin:0 auto;"></div>
                    <div>Secretary</div>
                </td>
                <td style="width:33%; border:none;">
                    <strong>Approved By:</strong><br><br>
                    <div style="border-top:1px solid #000; width:80%; margin:0 auto;"></div>
                    <div>Manager</div>
                </td>
                <td style="width:33%; border:none;">
                    <strong>Received By:</strong><br><br>
                    <div style="border-top:1px solid #000; width:80%; margin:0 auto;"></div>
                    <div>Shop Technician</div>
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
