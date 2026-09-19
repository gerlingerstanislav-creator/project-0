<x-layout title="Идеи для стартапов">
    <section class="page startup-ideas">
        <p class="page__eyebrow">Tool 01</p>
        <h1>Идеи для стартапов</h1>
        <p class="page__description">Список идей из базы проекта. Наведи на идею и нажми карандаш, чтобы изменить название или описание.</p>

        <div class="startup-ideas__list">
            @forelse ($ideas as $idea)
                <details class="startup-idea" data-startup-idea data-update-url="{{ route('tools.tool1.update', $idea) }}">
                    <summary class="startup-idea__title">
                        <span class="startup-idea__title-text" data-editable="title">{{ $idea->title }}</span>
                        <span class="startup-idea__icon" aria-hidden="true">+</span>
                    </summary>

                    <button class="startup-idea__edit" type="button" data-edit-button aria-label="Редактировать идею">
                        <span aria-hidden="true">✎</span>
                    </button>

                    <div class="startup-idea__description">
                        <p class="startup-idea__description-text" data-editable="description">{{ $idea->description }}</p>
                    </div>

                    <div class="startup-idea__actions" data-edit-actions hidden>
                        <button class="startup-idea__button startup-idea__button--secondary" type="button" data-cancel-edit>Отмена</button>
                        <button class="startup-idea__button" type="button" data-save-edit>Сохранить</button>
                        <span class="startup-idea__status" data-edit-status role="status" aria-live="polite"></span>
                    </div>
                </details>
            @empty
                <div class="startup-ideas__empty">Пока нет идей.</div>
            @endforelse
        </div>
    </section>
</x-layout>
