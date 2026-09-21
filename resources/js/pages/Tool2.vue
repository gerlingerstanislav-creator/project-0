<script setup>
import { computed, ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';

const sips = ref(0);
const pouring = ref(false);
const glass = ref(false);
const drinking = ref(false);

const pour = () => {
    if (pouring.value || glass.value) return;

    sips.value = 0;
    glass.value = true;
    pouring.value = true;

    window.setTimeout(() => {
        pouring.value = false;
    }, 700);
};

const sip = () => {
    if (!glass.value || drinking.value) return;

    drinking.value = true;
    sips.value += 1;

    window.setTimeout(() => {
        drinking.value = false;

        if (sips.value >= 4) {
            glass.value = false;
        }
    }, 550);
};

const beerLevel = computed(() => (glass.value ? Math.max(0, 100 - sips.value * 25) : 0));
const label = computed(() => `${sips.value} / 4 ${sips.value === 1 ? 'глоток' : sips.value >= 2 && sips.value <= 4 ? 'глотка' : 'глотков'}`);
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
                    <button
                        class="beer-game__object beer-game__bottle"
                        :class="{ 'is-pouring': pouring }"
                        type="button"
                        aria-label="Налить пиво"
                        :disabled="pouring || glass"
                        @click="pour"
                    >
                        <span class="beer-game__bottle-glass"><span class="beer-game__beer beer-game__beer--bottle"></span><span class="beer-game__bottle-label">BEER</span></span>
                        <span class="beer-game__neck"></span><span class="beer-game__cap"></span><span class="beer-game__hint">Налить</span>
                    </button>

                    <div class="beer-game__pour" :class="{ 'is-active': pouring }" aria-hidden="true"><span></span></div>

                    <button
                        class="beer-game__object beer-game__cup"
                        :class="{ 'is-drinking': drinking }"
                        type="button"
                        aria-label="Выпить пиво"
                        :disabled="!glass || drinking"
                        @click="sip"
                    >
                        <span class="beer-game__cup-glass">
                            <span
                                class="beer-game__beer beer-game__beer--cup"
                                :style="{ '--beer-level': `${beerLevel}%` }"
                            ></span>
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
