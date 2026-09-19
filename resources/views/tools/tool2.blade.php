<x-layout title="Степан, выпей">
    <section class="page beer-game-page">
        <p class="page__eyebrow">Page 02</p>
        <h1>Степан, выпей</h1>
        <p class="page__description">Нажми на бутылку, чтобы налить пиво в стакан. В стакане помещается до четырёх глотков.</p>
        <div class="beer-game" data-beer-game>
            <div class="beer-game__scene" aria-label="Мини-игра с бутылкой пива и стаканом">
                <button class="beer-game__object beer-game__bottle" type="button" data-beer-bottle aria-label="Налить пиво">
                    <span class="beer-game__bottle-glass"><span class="beer-game__beer beer-game__beer--bottle"></span><span class="beer-game__bottle-label">BEER</span></span>
                    <span class="beer-game__neck"></span><span class="beer-game__cap"></span>
                    <span class="beer-game__hint">Налить</span>
                </button>
                <div class="beer-game__pour" aria-hidden="true" data-beer-pour><span></span></div>
                <button class="beer-game__object beer-game__cup" type="button" data-beer-cup aria-label="Выпить пиво">
                    <span class="beer-game__cup-glass">
                        <span class="beer-game__beer beer-game__beer--cup" data-beer-cup-liquid></span>
                        <span class="beer-game__foam"></span>
                        <span class="beer-game__sip-markers" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
                    </span>
                    <span class="beer-game__hint">Выпить</span>
                </button>
            </div>
            <div class="beer-game__status" aria-live="polite"><span data-beer-count>0 / 4 глотка</span></div>
        </div>
    </section>
</x-layout>
