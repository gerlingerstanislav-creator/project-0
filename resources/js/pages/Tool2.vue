<script setup>
import { computed, ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';

const bottles = ref([
    { id: 1, beer: 4, open: false },
]);
const activeBottleId = ref(1);
const nextBottleId = ref(2);
const glassBeer = ref(0);
const pouring = ref(false);
const pouringBottleId = ref(null);
const drinking = ref(false);

const activeBottle = computed(() => bottles.value.find((bottle) => bottle.id === activeBottleId.value));

const openBottle = (bottle) => {
    if (bottle.id !== activeBottleId.value || bottle.open || bottle.beer <= 0 || pouring.value) return;
    bottle.open = true;
};

const pour = (bottle) => {
    if (
        bottle.id !== activeBottleId.value
        || !bottle.open
        || pouring.value
        || bottle.beer <= 0
        || glassBeer.value >= 4
    ) {
        return;
    }

    pouring.value = true;
    pouringBottleId.value = bottle.id;

    window.setTimeout(() => {
        bottle.beer -= 1;
        glassBeer.value += 1;
        pouring.value = false;
        pouringBottleId.value = null;

        if (bottle.beer === 0) {
            const newBottle = {
                id: nextBottleId.value,
                beer: 4,
                open: false,
            };

            nextBottleId.value += 1;
            bottles.value.unshift(newBottle);
            activeBottleId.value = newBottle.id;
        }
    }, 700);
};

const handleBottleClick = (bottle) => {
    if (bottle.id !== activeBottleId.value) return;
    bottle.open ? pour(bottle) : openBottle(bottle);
};

const drink = () => {
    if (glassBeer.value <= 0 || drinking.value) return;
    drinking.value = true;
    window.setTimeout(() => {
        glassBeer.value = 0;
        drinking.value = false;
    }, 550);
};

const bottleLevel = (bottle) => (bottle.beer / 4) * 100;
const glassLevel = computed(() => (glassBeer.value / 4) * 100);

const bottleHint = (bottle) => {
    if (bottle.id !== activeBottleId.value) return 'Пустая бутылка';
    if (!bottle.open) return 'Открыть бутылку';
    if (bottle.beer <= 0) return 'Бутылка пуста';
    if (glassBeer.value >= 4) return 'Стакан полный';
    return 'Налить';
};

const status = computed(() => {
    if (!activeBottle.value?.open) return 'Бутылка закрыта';
    return `Бутылка: ${activeBottle.value.beer}/4 · Стакан: ${glassBeer.value}/4`;
});
</script>

<template>
    <Head title="Степан, выпей" />
    <AppLayout>
        <section class="page beer-game-page">
            <p class="page__eyebrow">Page 02</p>
            <h1>Степан, выпей</h1>
            <p class="page__description">Открой бутылку, кликай по ней, чтобы наливать пиво в стакан, затем кликай по стакану, чтобы выпивать. Когда бутылка закончится, новая бутылка появится слева, а пустая останется на месте.</p>
            <div class="beer-game">
                <div
                    class="beer-game__scene"
                    :style="{ '--bottle-count': bottles.length }"
                    aria-label="Мини-игра с бутылками пива и стаканом"
                >
                    <div class="beer-game__bottles">
                        <button
                            v-for="bottle in bottles"
                            :key="bottle.id"
                            class="beer-game__object beer-game__bottle"
                            :class="{
                                'is-pouring': pouringBottleId === bottle.id,
                                'is-open': bottle.open,
                            }"
                            type="button"
                            :aria-label="bottleHint(bottle)"
                            :disabled="bottle.id !== activeBottleId || pouring || bottle.beer <= 0 || glassBeer >= 4"
                            @click="handleBottleClick(bottle)"
                        >
                            <span class="beer-game__bottle-glass">
                                <span class="beer-game__beer beer-game__beer--bottle" :style="{ '--bottle-level': `${bottleLevel(bottle)}%` }"></span>
                                <span class="beer-game__bottle-label">BEER</span>
                            </span>
                            <span class="beer-game__neck"></span>
                            <span class="beer-game__cap"></span>
                            <span class="beer-game__hint">{{ bottleHint(bottle) }}</span>
                        </button>
                    </div>

                    <div class="beer-game__pour" :class="{ 'is-active': pouring }" aria-hidden="true"><span></span></div>

                    <button
                        class="beer-game__object beer-game__cup"
                        :class="{ 'is-drinking': drinking }"
                        type="button"
                        aria-label="Выпить пиво"
                        :disabled="glassBeer <= 0 || drinking"
                        @click="drink"
                    >
                        <span class="beer-game__cup-glass">
                            <span class="beer-game__beer beer-game__beer--cup" :style="{ '--beer-level': `${glassLevel}%` }"></span>
                            <span class="beer-game__foam" :style="{ '--beer-level': `${glassLevel}%` }"></span>
                            <span class="beer-game__sip-markers" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
                        </span>
                        <span class="beer-game__hint">Выпить</span>
                    </button>
                </div>
                <div class="beer-game__status" aria-live="polite">{{ status }}</div>
            </div>
        </section>
    </AppLayout>
</template>
