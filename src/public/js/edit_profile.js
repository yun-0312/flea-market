document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.querySelector('.edit-profile-form__image-input');
    const previewImage = document.querySelector('.edit-profile-form__image-preview');
    const placeholder = document.querySelector('.edit-profile-form__image-placeholder');
    const imageCircle = document.querySelector('.edit-profile-form__image-circle');

    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // 既にプレビュー画像がある場合はそれを使う
                if (previewImage) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                } else {
                    // 初めて選択された場合は新しくimg要素を追加
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'プロフィール画像プレビュー';
                    img.classList.add('edit-profile-form__image-preview');
                    imageCircle.innerHTML = ''; // プレースホルダー削除
                    imageCircle.appendChild(img);
                }

                // プレースホルダーは非表示
                if (placeholder) placeholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else {
            // ファイル選択を取り消した場合
            if (previewImage) {
                previewImage.style.display = 'none';
            }
            if (placeholder) {
                placeholder.style.display = 'block';
            }
        }
    });
});