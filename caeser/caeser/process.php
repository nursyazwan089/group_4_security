<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action === "encrypt") {
        header("Location: encrypt.php?" . http_build_query($_POST));
        exit();
    } elseif ($action === "decrypt") {
        header("Location: decrypt.php?" . http_build_query($_POST));
        exit();
    } else {
        echo "Invalid action selected.";
    }
} else {
    echo "Access denied.";
}
?>
