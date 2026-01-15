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



// Get voucher/order ID
$id = isset($_GET['oid']) ? intval($_GET['oid']) : 0;

if ($id) {
    // Fetch order data
    $sql = $conn->prepare("SELECT * FROM tbl_order WHERE od_id = ?");
    $sql->execute([$id]);

    if ($sql->rowCount() > 0) {
        $data = $sql->fetch();
        $voucher_no = $data['jo_num'];

        // Create new PDF document
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('LUVIMAR FIRE CONTROL AVENUE');
        $pdf->SetTitle('Job Order Slip');
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(TRUE, 10);
        $pdf->AddPage();

        $company_logo = '../images/branch_logo/main.png'; // Path to the Crave Technology logo (adjust as needed)
        if (file_exists($company_logo)) {
            $pdf->Image($company_logo, 30, 25, 30, 30, '', '', '', false, 300, '', false, false, 0, false, false, false);
        }

        // HTML content for PDF
        $html = '
        <style>
            table { border-collapse: collapse; width: 100%; font-size: 12px; }
            table, th, td { border: 1px solid #000; padding: 4px; }
            .header { text-align: center; font-size: 14px; margin-bottom: 5px; }
         
        </style>
        <div class="header">
            <h3>LUVIMAR FIRE CONTROL AVENUE</h3>
            <p>Terra Plaza, Cor. Rizal - Gatualas Sts., Bacolod City</p>
            <p>Tel. Nos: 476-2612 / 708-6185 / 213-2714</p>
            <p>Mobile Nos: 0949-3934805 / 0912-5374747</p>
            <strong>JOB ORDER SLIP</strong> - <strong>No. ' . $voucher_no . '</strong>
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
            <tr>
                <td>5/26</td>
      
                <td>South Bacolod General Hospital</td>
                <td>21</td>
                <td>MAP 10 Lb</td>
                <td>✔ REF</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>South Bacolod General Hospital</td>
                <td>5</td>
                <td>MAP 20 Lb</td>
                <td>✔ REF</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>5/26</td>
                <td>26</td>
                <td>South Bacolod General Hospital</td>
                <td>2</td>
                <td>BHP 10 Lb</td>
                <td>✔ BN</td>
                <td></td>
                <td></td>
            </tr>
        </table>
<br><br>
<table style="width:100%; margin-top:30px; text-align:center; border-collapse:collapse; font-size:12px; border:none;">
    <tr>
        <td style="width:33%; border:none;">
            <strong>Requested By:</strong><br><br>
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
        $pdf->Output('joborder_' . $voucher_no . '.pdf', 'I');
    } else {
        echo "Job order not found.";
    }
} else {
    echo "Invalid ID.";
}
