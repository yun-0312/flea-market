document.addEventListener("DOMContentLoaded", () => {
    function autoResize(textarea) {
        textarea.style.height = "auto";
        textarea.style.height = textarea.scrollHeight + "px";
    }

    document.querySelectorAll(".message-form__textarea").forEach((t) => {
        autoResize(t);
    });

    const targetId = window.transactionConfig?.updatedMessageId;
    if (targetId) {
        const el = document.getElementById(`message-${targetId}`);
        if (el) {
            el.scrollIntoView({ behavior: "smooth", block: "center" });
        }
    }
});
