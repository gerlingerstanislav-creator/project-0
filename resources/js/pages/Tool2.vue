<script setup>
import { computed, ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';

const sips = ref(0);
const pouring = ref(false);
const glass = ref(false);

const pour = () => {
    if (pouring.value || sips.value >= 4) return;
    pouring.value = true;
    glass.value = true;
    window.setTimeout(() => { pouring.value = false; }, 700);
};

const sip = () => {
    if (sips.value >= 4 || !glass.value) return;
    sips.value += 1;
    if (sips.value >= 4) glass.value = false;
};

const label = computed(() => `${sips.value} / 4 глотка`);
</script>

<template>
    <Head title="Степан, выпей" />
    <AppLayout>
        <section class="page beer-game-page">
            <p class="page__eyebrow">Page 02</p>
            <h1>Степан, выпей</h1>
            <p class="page__description">Нажми на бутылку, чтобы налить пиво в стакан. В стакане помещается до четырёх глотков.</p>
            <div class="beer-game">
                <div class="beer-game__scene" aria-label="Мини-игра с бутылкой пива и стаканом">
                    <button class="beer-game__object beer-game__bottle" type="button" aria-label="Налить пиво" @click="pour">
                        <span class="beer-game__bottle-glass"><span class="beer-game__beer beer-game__beer--bottle"></span><span class="beer-game__bottle-label">BEER</span></span>
                        <span class="beer-game__neck"></span><span class="beer-game__cap"></span><span class="beer-game__hint">Налить</span>
                    </button>
                    <div class="beer-game__pour" :class="{ 'is-pouring': pouring }" aria-hidden="true"><span></span></div>
                    <button class="beer-game__object beer-game__cup" type="button" aria-label="Выпить пиво" :disabled="!glass" @click="sip">
                        <span class="beer-game__cup-glass">
                            <span class="beer-game__beer beer-game__beer--cup" :style="{ transform: `scaleY(${Math.max(0, 1 - sips / 4)})` }"></span>
                            <span class="beer-game__foam"></span>
                            <span class="beer-game__sip-markers" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
                        </span>
                        <span class="beer-game__hint">Выпить</span>
                    </button>
                </div>
                <div class="beer-game__status" aria-live="polite">{{ label }}</div>
            </div>
        </section>
    </AppLayout>
</template>
