function generateReverseFreqMap(text) {
    const cleanText = text.toUpperCase().replace(/[^A-Z]/g, '');

    // Frequency count
    const frequencyMap = {};
    for (const char of cleanText) {
        frequencyMap[char] = (frequencyMap[char] || 0) + 1;
    }

    // Sort letters by frequency
    const sortedLetters = Object.keys(frequencyMap).sort((a, b) => {
        return frequencyMap[b] - frequencyMap[a] || a.localeCompare(b);
    });

    const englishFreq = 'ETAOINSHRDLCUMWFGYPBVKJXQZ';
    const reversedFreq = englishFreq.split('').reverse();

    const map = {};
    sortedLetters.forEach((char, index) => {
        map[char] = reversedFreq[index];
    });

    return map; // Save this map for both encrypt and decrypt
}

// Caesar helper
function caesarShift(char, shift) {
    const base = char === char.toLowerCase() ? 'a'.charCodeAt(0) : 'A'.charCodeAt(0);
    const code = char.charCodeAt(0) - base;
    const shifted = (code + shift + 26) % 26; // wrap around
    return String.fromCharCode(base + shifted);
}

// Cipher application with hybrid option
function applyCipher(text, map, reverse = false, useCaesar = false, caesarAmount = 3) {
    // Create reverse map if decrypting
    const cipherMap = reverse
        ? Object.fromEntries(Object.entries(map).map(([k, v]) => [v, k]))
        : map;

    let result = '';
    for (const char of text) {
        const isLower = char === char.toLowerCase();
        const upperChar = char.toUpperCase();

        if (/[A-Z]/.test(upperChar)) {
            let finalChar;

            if (reverse && useCaesar) {
                // Decrypt Caesar first, then reverse freq
                const caesarChar = caesarShift(upperChar, -caesarAmount);
                finalChar = cipherMap[caesarChar] || caesarChar;
            } else {
                // Reverse freq first
                const subChar = cipherMap[upperChar] || upperChar;
                finalChar = useCaesar ? caesarShift(subChar, caesarAmount) : subChar;
            }

            result += isLower ? finalChar.toLowerCase() : finalChar;
        } else {
            result += char; // Preserve punctuation, spaces, etc.
        }
    }

    return result;
}