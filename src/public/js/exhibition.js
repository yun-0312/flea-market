const input = document.querySelector('.exhibition-form__image-input');
const preview = document.getElementById('preview');
const label = document.querySelector('.exhibition-form__image-label');
const imageWrapper = document.querySelector('.exhibition-form__image');
const removeBtn = document.getElementById('removeImage');

input.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            preview.src = event.target.result;
            imageWrapper.style.display = 'flex';
            label.style.display = 'none';
            removeBtn.style.display = 'block'; // ×ボタンを表示
        };
        reader.readAsDataURL(file);
    }
});

removeBtn.addEventListener('click', function() {
    preview.src = '';
    imageWrapper.style.display = 'none';
    label.style.display = 'flex';
    removeBtn.style.display = 'none';
    input.value = ''; // ファイル選択リセット
});