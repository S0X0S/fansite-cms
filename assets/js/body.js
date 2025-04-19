document.addEventListener('DOMContentLoaded', function () {
    const textarea = document.getElementById('comment-textarea');
    const autocompleteList = document.createElement('ul');
    autocompleteList.style.position = 'absolute';
    autocompleteList.style.zIndex = '1000';
    autocompleteList.style.listStyleType = 'none';
    autocompleteList.style.backgroundColor = 'white';
    autocompleteList.style.border = '1px solid #ccc';
    autocompleteList.style.padding = '5px';
    autocompleteList.style.display = 'none';
    document.body.appendChild(autocompleteList);

    let lastWord = '';

    textarea.addEventListener('input', function () {
        const cursorPosition = textarea.selectionStart;
        const textBeforeCursor = textarea.value.substring(0, cursorPosition);
        const match = textBeforeCursor.match(/@(\w*)$/);

        if (match) {
            lastWord = match[1];

            // Kullanıcı adı tamamlaması için AJAX çağrısı
            fetch(`/includes/get_users.php?term=${encodeURIComponent(lastWord)}`)
                .then(response => response.json())
                .then(usernames => {
                    autocompleteList.innerHTML = '';
                    if (usernames.length > 0) {
                        usernames.forEach(username => {
                            const li = document.createElement('li');
                            li.textContent = username;
                            li.style.cursor = 'pointer';
                            li.addEventListener('click', function () {
                                // Kullanıcı adını tamamla
                                const textAfterCursor = textarea.value.substring(cursorPosition);
                                textarea.value = textBeforeCursor.replace(/@\w*$/, '@' + username) + textAfterCursor;
                                autocompleteList.style.display = 'none';
                                textarea.focus();
                            });
                            autocompleteList.appendChild(li);
                        });
                        const rect = textarea.getBoundingClientRect();
                        autocompleteList.style.left = rect.left + 'px';
                        autocompleteList.style.top = (rect.top + window.scrollY + textarea.offsetHeight) + 'px';
                        autocompleteList.style.display = 'block';
                    } else {
                        autocompleteList.style.display = 'none';
                    }
                });
        } else {
            autocompleteList.style.display = 'none';
        }
    });

    // Kullanıcı liste dışı tıkladığında kapat
    document.addEventListener('click', function (e) {
        if (e.target !== autocompleteList && e.target !== textarea) {
            autocompleteList.style.display = 'none';
        }
    });
});
