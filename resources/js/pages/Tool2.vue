<script setup>
import { computed, ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';

const bottleOpen = ref(false);
const bottleBeer = ref(4);
const glassBeer = ref(0);
const pouring = ref(false);
const drinking = ref(false);

const openBottle = () => {
    if (bottleOpen.value || bottleBeer.value <= 0) return;
    bottleOpen.value = true;
};

const pour = () => {
    if (!bottleOpen.value || pouring.value || bottleBeer.value <= 0 || glassBeer.value >= 4) return;
    pouring.value = true;
    window.setTimeout(() => {
        bottleBeer.value -= 1;
        glassBeer.value += 1;
        pouring.value = false;
    }, 700);
};

const drink = () => {
    if (glassBeer.value <= 0 || drinking.value) return;
    drinking.value = true;
    window.setTimeout(() => {
        glassBeer.value = 0;
        drinking.value = false;
    }, 550);
};

const takeNewBottle = () => {
    if (bottleBeer.value > 0 || pouring.value) return;
    bottleBeer.value = 4;
    bottleOpen.value = false;
};

const bottleLevel = computed(() => (bottleBeer.value / 4) * 100);
const glassLevel = computed(() => (glassBeer.value / 4) * 100);
const bottleHint = computed(() => {
    if (!bottleOpen.value) return 'Открыть бутылку';
    if (bottleBeer.value <= 0) return 'Бутылка пустая';
    if (glassBeer.value >= 4) return 'Стакан полный';
    return 'Налить';
});
const status = computed(() => {
    if (!bottleOpen.value) return 'Бутылка закрыта';
    if (bottleBeer.value <= 0) return 'Бутылка пуста';
    return `Бутылка: ${bottleBeer.value}/4 · Стакан: ${glassBeer.value}/4`;
});
</script>

<template>
    <Head title="Степан, выпей" />
    <AppLayout>
        <section class="page beer-game-page">
            <p class="page__eyebrow">Page 02</p>
            <h1>Степан, выпей</h1>
            <p class="page__description">Открой бутылку, кликай по ней, чтобы наливать пиво в стакан, затем кликай по стакану, чтобы выпивать. Когда бутылка закончится, возьми новую.</p>
            <div class="beer-game">
                <div class="beer-game__scene" aria-label="Мини-игра с бутылкой пива и стаканом">
                    <button
                        class="beer-game__object beer-game__bottle"
                        :class="{ 'is-pouring': pouring, 'is-open': bottleOpen }"
                        type="button"
                        :aria-label="bottleHint"
                        :disabled="pouring || bottleBeer <= 0 || glassBeer >= 4"
                        @click="bottleOpen ? pour() : openBottle()"
                    >
                        <span class="beer-game__bottle-glass">
                            <span class="beer-game__beer beer-game__beer--bottle" :style="{ '--bottle-level': `${bottleLevel}%` }"></span>
                            <span class="beer-game__bottle-label">BEER</span>
                        </span>
                        <span class="beer-game__neck"></span>
                        <span class="beer-game__cap"></span>
                        <span class="beer-game__hint">{{ bottleHint }}</span>
                    </button>

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
                <button v-if="bottleBeer === 0" class="beer-game__new-bottle" type="button" @click="takeNewBottle">Взять новую бутылку</button>
            </div>
        </section>
    </AppLayout>
</template>
