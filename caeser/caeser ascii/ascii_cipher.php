<?php
function asciiShift($text, $shift, $mode = 'encrypt') {
    $result = '';
    $min = 32; // space
    $max = 126; // tilde (~)
    $range = $max - $min + 1;

    if ($mode === 'decrypt') {
        $shift = -$shift;
    }

    for ($i = 0; $i < strlen($text); $i++) {
        $charCode = ord($text[$i]);

        if ($charCode >= $min && $charCode <= $max) {
            $shifted = (($charCode - $min + $shift) % $range + $range) % $range + $min;
            $result .= chr($shifted);
        } else {
            // If not in printable range, keep as-is
            $result .= $text[$i];
        }
    }

    return $result;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'] ?? '';
    $shift = intval($_POST['shift'] ?? 0);
    $action = $_POST['action'] ?? 'encrypt';

    $output = asciiShift($message, $shift, $action);

    echo "<h2>Result ($action)</h2>";
    echo "<p><strong>Original:</strong> " . htmlspecialchars($message) . "</p>";
    echo "<p><strong>Processed:</strong> " . htmlspecialchars($output) . "</p>";

    echo "<br><form action='index.html' method='get'>
            <button type='submit'>Try Again</button>
          </form>";
} else {
    echo "Invalid access.";
}
?>
