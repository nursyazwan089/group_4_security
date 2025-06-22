<?php
function caesarDecrypt($text, $shift) {
    // Decryption is just encryption with the negative shift
    return caesarEncrypt($text, -$shift);
}

function caesarEncrypt($text, $shift) {
    $result = '';
    $shift = $shift % 26;

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        if (ctype_upper($char)) {
            $result .= chr((ord($char) - 65 + $shift + 26) % 26 + 65);
        } elseif (ctype_lower($char)) {
            $result .= chr((ord($char) - 97 + $shift + 26) % 26 + 97);
        } else {
            $result .= $char;
        }
    }

    return $result;
}

$message = $_GET['message'] ?? '';
$shift = intval($_GET['shift'] ?? 0);
$decrypted = caesarDecrypt($message, $shift);

echo "<h2>Decrypted Result</h2>";
echo "<p><strong>Encrypted:</strong> " . htmlspecialchars($message) . "</p>";
echo "<p><strong>Decrypted:</strong> " . htmlspecialchars($decrypted) . "</p>";
echo "<br><a href='index.html'>Back</a>";
?>
