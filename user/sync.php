<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    date_default_timezone_set('Asia/Manila'); // ensure correct timezone
    $dbName = 'db_gleamz_main';
    $dbUser = 'root';
    $dbPass = '';
    $folder = 'sql';

    // ⏱ Generate filename like: backup_2025-05-05_153027.sql
    $timestamp = date('Y-m-d_His');
    $fileName = "backup_$timestamp.sql";
    $fullPath = $folder . DIRECTORY_SEPARATOR . $fileName;

    // ✅ Path to mysqldump
    $mysqldumpPath = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';

    // ✅ Make sure 'sql' folder exists
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    // ✅ Build command with --ignore-table option
    $ignoreTable = "--ignore-table=$dbName.bs_setting --ignore-table=$dbName.bs_user";
    $command = "\"$mysqldumpPath\" -u$dbUser $ignoreTable $dbName > \"$fullPath\"";

    // ✅ Run the backup command
    shell_exec($command);

    // ✅ Check if file was created
    if (file_exists($fullPath)) {
        // echo "<p>✅ Backup created successfully: <strong>$fullPath</strong></p>";

        // ✅ Upload to Hostinger
        $ch = curl_init();
        $cfile = new CURLFile($fullPath, 'application/sql', $fileName);
        $postData = ['sql_file' => $cfile];

        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://convenience.cravetechsolutions.com/sql_importer.php',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10, // Timeout for no connection
            CURLOPT_TIMEOUT => 30,        // Max time to allow curl to run
        ]);

        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        $curlErrno = curl_errno($ch);
        curl_close($ch);

        echo "<h3>📤 Upload Result: Success</h3>";
        if ($curlErrno) {
            echo "<p style='color:red;'>❌ Upload failed. Please check your internet connection.<br>Error: <strong>$curlError</strong></p>";
        } else {
            echo $response;
        }
    } else {
        echo "<p>❌ Failed to create backup file at: $fullPath</p>";
    }
}
?>

<!-- HTML form to trigger backup -->
<!DOCTYPE html>
<html>

<head>
    <title>Sync to Hostinger</title>
</head>

<body>
    <h2>🔄 Sync Local DB to Hostinger</h2>
    <form method="POST">
        <button type="submit">📤 Backup & Upload</button>
    </form>
</body>

</html>