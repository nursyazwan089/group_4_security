<?php
function caesarEncrypt($text, $shift) {
    $result = '';
    $shift = $shift % 26;

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        if (ctype_upper($char)) {
            $result .= chr((ord($char) - 65 + $shift) % 26 + 65);
        } elseif (ctype_lower($char)) {
            $result .= chr((ord($char) - 97 + $shift) % 26 + 97);
        } else {
            $result .= $char;
        }
    }

    return $result;
}

$message = $_GET['message'] ?? '';
$shift = intval($_GET['shift'] ?? 0);
$encrypted = caesarEncrypt($message, $shift);

echo "<h2>Encrypted Result</h2>";
echo "<p><strong>Original:</strong> " . htmlspecialchars($message) . "</p>";
echo "<p><strong>Encrypted:</strong> " . htmlspecialchars($encrypted) . "</p>";

echo "<br><form action='index.html' method='get'>
        <button type='submit'>Try Again</button>
      </form>";
?>
