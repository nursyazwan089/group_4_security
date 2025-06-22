<?php
// 1. Create frequency list and its reverse
$freq = str_split("ETAOINSHRDLCUMWFGYPBVKJXQZ"); // High → Low frequency
$rev_freq = array_reverse($freq);

// 2. Build full symmetric mapping (A→Z, B→Y, ... Z→A based on frequency)
$map_upper = array_combine($freq, $rev_freq);

// 3. Add reversed entries to ensure decryption works too
foreach ($map_upper as $k => $v) {
    $map_upper[$v] = $k;
}

// 4. Lowercase version
$map_lower = [];
foreach ($map_upper as $k => $v) {
    $map_lower[strtolower($k)] = strtolower($v);
}

// 5. Get user input
$plaintext = $_POST['plaintext'] ?? '';
$mode = $_POST['mode'] ?? 'encrypt';
$result = '';

// 6. Process each character
for ($i = 0; $i < strlen($plaintext); $i++) {
    $char = $plaintext[$i];

    if (ctype_upper($char)) {
        $result .= $map_upper[$char] ?? $char;
    } elseif (ctype_lower($char)) {
        $result .= $map_lower[$char] ?? $char;
    } else {
        $result .= $char; // punctuation, space, etc.
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Result - Reverse Frequency Cipher</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background: linear-gradient(to right, #e3f2fd, #fce4ec);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            animation: fadeIn 0.8s ease;
        }
        .card {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 90%;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            font-weight: 700;
        }
        .result-box {
            background: #f8f9fa;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 12px;
            font-size: 18px;
            color: #555;
            white-space: pre-wrap;
            word-break: break-word;
            margin-bottom: 30px;
        }
        .btn {
            background: #4CAF50;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 10px;
            transition: background 0.3s ease;
            font-size: 16px;
        }
        .btn:hover {
            background: #43a047;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>🔐 Cipher Result</h2>
        <div class="result-box">
            <?php echo htmlspecialchars($result ?? 'No result'); ?>
        </div>
        <a href="index.html" class="btn">🔁 Try Another</a>
    </div>
</body>
</html>