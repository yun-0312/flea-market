document.addEventListener("DOMContentLoaded", () => {
    // ----------------------------------------
    // textarea 自動リサイズ（新規・編集共通）
    // ----------------------------------------
    function autoResize(textarea) {
        textarea.style.height = "auto";
        textarea.style.height = textarea.scrollHeight + "px";
    }

    document.querySelectorAll(".auto-resize").forEach((t) => {
        autoResize(t);
        t.addEventListener("input", () => autoResize(t));
    });

    // ----------------------------------------
    // 新規メッセージの下書き保存
    // ----------------------------------------
    const newMessageInput = document.getElementById(
        "transaction-message-create"
    );

    if (newMessageInput) {
        const transactionId = window.transactionId;
        const key = `draft_message_${transactionId}`;

        // 下書き復元
        const saved = localStorage.getItem(key);
        if (saved) {
            newMessageInput.value = saved;
            autoResize(newMessageInput);
        }

        // 入力のたびに保存
        newMessageInput.addEventListener("input", () => {
            localStorage.setItem(key, newMessageInput.value);
        });

        // 送信時に削除
        const form = document.querySelector(".message-form__create");
        if (form) {
            form.addEventListener("submit", () => {
                localStorage.removeItem(key);
            });
        }
    }

    // ----------------------------------------
    // 編集フォームの開閉
    // ----------------------------------------
    document.addEventListener("click", (e) => {
        // 編集ボタン → 編集フォームを開く
        if (e.target.classList.contains("edit-toggle")) {
            const id = e.target.dataset.id;
            const form = document.getElementById(`edit-form-${id}`);
            if (form) {
                form.style.display = "block";
            }
        }

        // キャンセル → 編集フォームを閉じる
        if (e.target.classList.contains("cancel-edit")) {
            const id = e.target.dataset.id;
            const form = document.getElementById(`edit-form-${id}`);
            if (form) {
                form.style.display = "none";
            }
        }
    });

    // ----------------------------------------
    // 編集後のスクロール位置復元
    // ----------------------------------------
    const targetId = window.transactionConfig?.updatedMessageId;
    if (targetId) {
        const el = document.getElementById(`message-${targetId}`);
        if (el) {
            el.scrollIntoView({ behavior: "smooth", block: "center" });
        }
    }

    // エラーがない場合は全ての編集フォームを閉じる
    if (!window.transactionConfig?.updatedMessageId) {
        document.querySelectorAll(".edit-form").forEach((form) => {
            form.style.display = "none";
        });
    }

    // ----------------------------------------
    // 新規メッセージ追加後のスクロール
    // ----------------------------------------
    const lastId = window.transactionConfig?.lastMessageId;
    if (lastId) {
        const el = document.getElementById(`message-${lastId}`);
        if (el) {
            el.scrollIntoView({ behavior: "smooth", block: "center" });
        }
    }

    // ----------------------------------------
    // ハンバーガーメニュー（サイドバー開閉）
    // ----------------------------------------
    const hamburger = document.querySelector(".hamburger");
    const sidebar = document.querySelector(".sidebar");

    if (hamburger && sidebar) {
        hamburger.addEventListener("click", () => {
            sidebar.classList.toggle("open");
        });
    }
});
