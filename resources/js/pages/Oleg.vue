<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';
</script>

<template>
    <Head title="Привет, Олег" />

    <AppLayout>
        <main class="oleg-page">
            <section class="oleg-banner" aria-labelledby="oleg-title">
                <div class="oleg-banner__glow oleg-banner__glow--one"></div>
                <div class="oleg-banner__glow oleg-banner__glow--two"></div>
                <div class="oleg-banner__content">
                    <span class="oleg-banner__eyebrow">WELCOME</span>
                    <h1 id="oleg-title">Привет, Олег</h1>
                    <p>Рады видеть тебя здесь.</p>
                </div>
                <div class="oleg-banner__mark" aria-hidden="true">✦</div>
            </section>
        </main>
    </AppLayout>
</template>

<style scoped>
.oleg-page {
    min-height: calc(100vh - 96px);
    display: grid;
    place-items: center;
}

.oleg-banner {
    position: relative;
    width: min(100%, 1080px);
    min-height: 430px;
    overflow: hidden;
    display: grid;
    place-items: center;
    padding: 56px;
    border-radius: 28px;
    background:
        radial-gradient(circle at 20% 20%, rgba(255,255,255,.18), transparent 32%),
        radial-gradient(circle at 85% 80%, rgba(255,255,255,.12), transparent 30%),
        linear-gradient(135deg, #18181b 0%, #27272a 48%, #09090b 100%);
    color: #fff;
    box-shadow: 0 30px 80px rgba(0,0,0,.18);
}

.oleg-banner::before {
    content: "";
    position: absolute;
    inset: 1px;
    border: 1px solid rgba(255,255,255,.14);
    border-radius: 27px;
    pointer-events: none;
}

.oleg-banner__content {
    position: relative;
    z-index: 2;
    text-align: center;
}

.oleg-banner__eyebrow {
    display: inline-block;
    margin-bottom: 18px;
    padding: 7px 11px;
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 999px;
    color: rgba(255,255,255,.68);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .18em;
}

.oleg-banner h1 {
    margin: 0;
    font-size: clamp(46px, 8vw, 96px);
    line-height: .95;
    letter-spacing: -.055em;
}

.oleg-banner p {
    margin: 24px 0 0;
    color: rgba(255,255,255,.62);
    font-size: clamp(15px, 2vw, 19px);
}

.oleg-banner__glow {
    position: absolute;
    width: 240px;
    height: 240px;
    border-radius: 50%;
    filter: blur(70px);
    opacity: .28;
}

.oleg-banner__glow--one {
    top: -100px;
    left: -60px;
    background: #a1a1aa;
}

.oleg-banner__glow--two {
    right: -70px;
    bottom: -120px;
    background: #71717a;
}

.oleg-banner__mark {
    position: absolute;
    right: 32px;
    top: 28px;
    color: rgba(255,255,255,.22);
    font-size: 42px;
}

@media (max-width: 700px) {
    .oleg-page {
        min-height: calc(100vh - 96px);
    }

    .oleg-banner {
        min-height: 360px;
        padding: 32px 22px;
        border-radius: 20px;
    }

    .oleg-banner::before {
        border-radius: 19px;
    }

    .oleg-banner__mark {
        right: 20px;
        top: 18px;
    }
}
</style>
