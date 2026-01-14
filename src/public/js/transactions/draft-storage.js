document.addEventListener("DOMContentLoaded", () => {
    const textarea = document.getElementById("transaction-message-input");
    if (!textarea) return;

    const transactionId = window.transactionConfig?.transactionId;
    if (!transactionId) return;

    const STORAGE_KEY = `transaction_message_${transactionId}`;

    const saved = localStorage.getItem(STORAGE_KEY);
    if (saved) textarea.value = saved;

    textarea.addEventListener("input", () => {
        localStorage.setItem(STORAGE_KEY, textarea.value);
    });
});