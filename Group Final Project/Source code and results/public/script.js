// Wait for DOM to load
window.addEventListener("DOMContentLoaded", () => {
    const modeSelector = document.getElementById("modeSelector");
    const inputText = document.getElementById("inputText");
    const useCaesar = document.getElementById("useCaesar");
    const caesarShift = document.getElementById("caesarShift");
    const mapInput = document.getElementById("mapInput");
    const outputText = document.getElementById("outputText");
    const mappingDisplay = document.getElementById("mappingDisplay");
    const copyOutputBtn = document.getElementById("copyOutputBtn");
    const copyMapBtn = document.getElementById("copyMapBtn");
    const actionBtn = document.getElementById("actionBtn");
    const decryptOnly = document.getElementById("decryptOnly");
    const mapSection = document.getElementById("mapSection");

    function updateMode() {
        const mode = modeSelector.value;
        decryptOnly.style.display = mode === "decrypt" ? "block" : "none";
        mapSection.style.display = mode === "decrypt" ? "none" : "block";
        outputText.textContent = "...";
        mappingDisplay.textContent = "...";
    }

    modeSelector.addEventListener("change", updateMode);
    updateMode();

    actionBtn.addEventListener("click", () => {
        const text = inputText.value.trim();
        const shift = parseInt(caesarShift.value) || 0;
        const caesar = useCaesar.checked;
        const mode = modeSelector.value;

        if (!text) {
            outputText.textContent = "Please enter some text.";
            return;
        }

        if (mode === "encrypt") {
            const map = generateReverseFreqMap(text);
            const encrypted = applyCipher(text, map, false, caesar, shift);

            outputText.textContent = encrypted;
            mappingDisplay.textContent = JSON.stringify(map, null, 2);
            mapSection.style.display = "block";
        } else {
            let map;
            try {
                map = JSON.parse(mapInput.value);
            } catch (err) {
                outputText.textContent = "Invalid frequency map format.";
                return;
            }

            const decrypted = applyCipher(text, map, true, caesar, shift);
            outputText.textContent = decrypted;
        }
    });

    copyOutputBtn.addEventListener("click", () => {
        navigator.clipboard.writeText(outputText.textContent.trim());
    });

    copyMapBtn.addEventListener("click", () => {
        navigator.clipboard.writeText(mappingDisplay.textContent.trim());
    });
});