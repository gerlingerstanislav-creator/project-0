const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

document.querySelectorAll('[data-startup-idea]').forEach((idea) => {
    const editButton = idea.querySelector('[data-edit-button]');
    const title = idea.querySelector('[data-editable="title"]');
    const description = idea.querySelector('[data-editable="description"]');
    const actions = idea.querySelector('[data-edit-actions]');
    const cancelButton = idea.querySelector('[data-cancel-edit]');
    const saveButton = idea.querySelector('[data-save-edit]');
    const status = idea.querySelector('[data-edit-status]');
    const updateUrl = idea.dataset.updateUrl;

    if (!editButton || !title || !description || !actions || !cancelButton || !saveButton || !status || !csrfToken || !updateUrl) {
        return;
    }

    let original = {
        title: title.textContent.trim(),
        description: description.textContent.trim(),
    };

    const setEditing = (editing) => {
        idea.classList.toggle('is-editing', editing);
        title.contentEditable = String(editing);
        description.contentEditable = String(editing);
        actions.hidden = !editing;
        editButton.hidden = editing;

        if (editing) {
            idea.open = true;
            title.focus();
        }
    };

    title.addEventListener('click', (event) => {
        if (idea.classList.contains('is-editing')) {
            event.preventDefault();
            event.stopPropagation();
        }
    });

    editButton.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();
        original = {
            title: title.textContent.trim(),
            description: description.textContent.trim(),
        };
        status.textContent = '';
        setEditing(true);
    });

    cancelButton.addEventListener('click', () => {
        title.textContent = original.title;
        description.textContent = original.description;
        status.textContent = '';
        setEditing(false);
    });

    saveButton.addEventListener('click', async () => {
        const payload = {
            title: title.textContent.trim(),
            description: description.textContent.trim(),
        };

        if (!payload.title || !payload.description) {
            status.textContent = 'Заполни название и описание.';
            return;
        }

        saveButton.disabled = true;
        status.textContent = 'Сохраняем…';

        try {
            const response = await fetch(updateUrl, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(payload),
            });

            if (!response.ok) {
                throw new Error('save_failed');
            }

            const data = await response.json();

            title.textContent = data.idea.title;
            description.textContent = data.idea.description;
            original = {
                title: data.idea.title,
                description: data.idea.description,
            };
            status.textContent = 'Сохранено';
            setEditing(false);
        } catch {
            status.textContent = 'Не удалось сохранить изменения.';
        } finally {
            saveButton.disabled = false;
        }
    });
});
