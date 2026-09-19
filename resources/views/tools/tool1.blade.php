<x-layout title="Идеи для стартапов">
    <section class="page startup-ideas">
        <p class="page__eyebrow">Tool 01</p>
        <h1>Идеи для стартапов</h1>
        <p class="page__description">Список идей, которые можно раскрыть и быстро просмотреть. Данные хранятся в базе проекта.</p>

        <div class="startup-ideas__list">
            @forelse ($ideas as $idea)
                <details class="startup-idea">
                    <summary class="startup-idea__title">
                        <span>{{ $idea->title }}</span>
                        <span class="startup-idea__icon" aria-hidden="true">+</span>
                    </summary>
                    <div class="startup-idea__description">
                        <p>{{ $idea->description }}</p>
                    </div>
                </details>
            @empty
                <div class="startup-ideas__empty">Пока нет идей.</div>
            @endforelse
        </div>
    </section>
</x-layout>
