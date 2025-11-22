const paymentSelect = document.getElementById('payment_method');
const paymentDisplay = document.getElementById('payment_display');
const changeLink = document.getElementById('changeLink');
const baseUrl = "{{ route('purchase.edit', ['item' => $item->id]) }}";

function updateChangeLink() {
    const selectedValue = paymentSelect.value;
    changeLink.href = baseUrl + '?payment_method=' + selectedValue;
}

function updateDisplay() {
    const selectedText = paymentSelect.options[paymentSelect.selectedIndex].text;
    paymentDisplay.textContent = selectedText;
}

// 初期化
updateChangeLink();
updateDisplay();

// 選択変更時に更新
paymentSelect.addEventListener('change', function() {
    updateDisplay();
    updateChangeLink();
});