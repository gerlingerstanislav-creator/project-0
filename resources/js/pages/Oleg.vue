<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';
</script>

<template>
    <Head title="Привет, Олег" />

    <AppLayout>
        <main class="oleg-page">
            <section class="oleg-banner" aria-labelledby="oleg-title">
                <div class="confetti" aria-hidden="true">
                    <span v-for="n in 18" :key="n" :class="'confetti__piece confetti__piece--' + n"></span>
                </div>
                <div class="oleg-banner__orb oleg-banner__orb--pink"></div>
                <div class="oleg-banner__orb oleg-banner__orb--blue"></div>
                <div class="oleg-banner__orb oleg-banner__orb--yellow"></div>

                <div class="oleg-banner__content">
                    <div class="oleg-banner__badge">✨ SPECIAL DELIVERY ✨</div>
                    <div class="oleg-banner__emoji" aria-hidden="true">🎉</div>
                    <h1 id="oleg-title">Привет, Олег!</h1>
                    <p>Этот баннер явно пришёл не за тем, чтобы быть скучным.</p>
                    <div class="oleg-banner__chips">
                        <span>🌈 Красочно</span>
                        <span>⚡ Ярко</span>
                        <span>🚀 С кайфом</span>
                    </div>
                </div>

                <div class="oleg-banner__sparkle oleg-banner__sparkle--one">✦</div>
                <div class="oleg-banner__sparkle oleg-banner__sparkle--two">✧</div>
                <div class="oleg-banner__star oleg-banner__star--one">★</div>
                <div class="oleg-banner__star oleg-banner__star--two">★</div>
            </section>
        </main>
    </AppLayout>
</template>

<style scoped>
.oleg-page {
    min-height: calc(100vh - 96px);
    display: grid;
    place-items: center;
    padding: 32px;
}

.oleg-banner {
    position: relative;
    width: min(100%, 1100px);
    min-height: 520px;
    overflow: hidden;
    display: grid;
    place-items: center;
    padding: 64px;
    border-radius: 36px;
    isolation: isolate;
    background:
        radial-gradient(circle at 50% 45%, rgba(255,255,255,.16), transparent 28%),
        linear-gradient(135deg, #ff4ecd 0%, #7c3aed 35%, #2563eb 67%, #06b6d4 100%);
    color: #fff;
    box-shadow:
        0 35px 90px rgba(99, 51, 177, .35),
        inset 0 1px 0 rgba(255,255,255,.35);
}

.oleg-banner::before {
    content: "";
    position: absolute;
    inset: 10px;
    border: 2px solid rgba(255,255,255,.22);
    border-radius: 29px;
    pointer-events: none;
    z-index: 3;
}

.oleg-banner__content {
    position: relative;
    z-index: 4;
    text-align: center;
    max-width: 850px;
}

.oleg-banner__badge {
    display: inline-block;
    padding: 9px 16px;
    border: 1px solid rgba(255,255,255,.4);
    border-radius: 999px;
    background: rgba(255,255,255,.16);
    box-shadow: 0 8px 30px rgba(0,0,0,.12);
    backdrop-filter: blur(12px);
    font-size: 11px;
    font-weight: 900;
    letter-spacing: .16em;
}

.oleg-banner__emoji {
    margin: 24px 0 4px;
    font-size: 58px;
    filter: drop-shadow(0 8px 10px rgba(0,0,0,.16));
}

.oleg-banner h1 {
    margin: 0;
    font-size: clamp(54px, 9vw, 108px);
    line-height: .9;
    letter-spacing: -.065em;
    text-shadow: 0 8px 24px rgba(39, 17, 84, .22);
}

.oleg-banner p {
    margin: 24px auto 0;
    color: rgba(255,255,255,.9);
    font-size: clamp(16px, 2vw, 20px);
    font-weight: 600;
}

.oleg-banner__chips {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 28px;
}

.oleg-banner__chips span {
    padding: 10px 15px;
    border-radius: 999px;
    background: rgba(255,255,255,.18);
    border: 1px solid rgba(255,255,255,.3);
    backdrop-filter: blur(10px);
    font-size: 13px;
    font-weight: 800;
}

.oleg-banner__orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(2px);
    z-index: 0;
}

.oleg-banner__orb--pink {
    width: 270px;
    height: 270px;
    top: -100px;
    left: -60px;
    background: #fb7185;
    opacity: .7;
}

.oleg-banner__orb--blue {
    width: 310px;
    height: 310px;
    right: -110px;
    bottom: -140px;
    background: #22d3ee;
    opacity: .75;
}

.oleg-banner__orb--yellow {
    width: 130px;
    height: 130px;
    right: 12%;
    top: 9%;
    background: #facc15;
    opacity: .9;
}

.oleg-banner__sparkle,
.oleg-banner__star {
    position: absolute;
    z-index: 2;
    color: #fff;
    text-shadow: 0 4px 16px rgba(0,0,0,.2);
}

.oleg-banner__sparkle--one {
    left: 10%;
    bottom: 18%;
    font-size: 58px;
    transform: rotate(15deg);
}

.oleg-banner__sparkle--two {
    right: 9%;
    top: 34%;
    font-size: 46px;
}

.oleg-banner__star--one {
    left: 19%;
    top: 16%;
    color: #fde047;
    font-size: 26px;
}

.oleg-banner__star--two {
    right: 20%;
    bottom: 15%;
    color: #f9a8d4;
    font-size: 34px;
}

.confetti {
    position: absolute;
    inset: 0;
    z-index: 1;
    pointer-events: none;
}

.confetti__piece {
    position: absolute;
    width: 9px;
    height: 22px;
    border-radius: 4px;
    background: #fff;
    opacity: .8;
}

.confetti__piece--1 { left: 7%; top: 22%; transform: rotate(24deg); background: #fef08a; }
.confetti__piece--2 { left: 14%; top: 69%; transform: rotate(-35deg); background: #67e8f9; }
.confetti__piece--3 { left: 27%; top: 8%; transform: rotate(70deg); background: #f9a8d4; }
.confetti__piece--4 { left: 38%; top: 82%; transform: rotate(18deg); background: #bef264; }
.confetti__piece--5 { left: 49%; top: 14%; transform: rotate(-50deg); background: #fde68a; }
.confetti__piece--6 { left: 58%; top: 77%; transform: rotate(42deg); background: #fda4af; }
.confetti__piece--7 { left: 70%; top: 20%; transform: rotate(-24deg); background: #a5f3fc; }
.confetti__piece--8 { left: 81%; top: 63%; transform: rotate(63deg); background: #fef08a; }
.confetti__piece--9 { left: 90%; top: 27%; transform: rotate(-18deg); background: #86efac; }
.confetti__piece--10 { left: 4%; top: 51%; transform: rotate(54deg); background: #fbcfe8; }
.confetti__piece--11 { left: 23%; top: 91%; transform: rotate(-60deg); background: #bae6fd; }
.confetti__piece--12 { left: 34%; top: 21%; transform: rotate(31deg); background: #ddd6fe; }
.confetti__piece--13 { left: 64%; top: 7%; transform: rotate(82deg); background: #fecaca; }
.confetti__piece--14 { left: 76%; top: 88%; transform: rotate(-42deg); background: #d9f99d; }
.confetti__piece--15 { left: 94%; top: 75%; transform: rotate(27deg); background: #fde68a; }
.confetti__piece--16 { left: 12%; top: 38%; transform: rotate(-68deg); background: #c4b5fd; }
.confetti__piece--17 { left: 86%; top: 47%; transform: rotate(55deg); background: #f9a8d4; }
.confetti__piece--18 { left: 54%; top: 92%; transform: rotate(-20deg); background: #67e8f9; }

@media (max-width: 700px) {
    .oleg-page {
        min-height: calc(100vh - 96px);
        padding: 16px;
    }

    .oleg-banner {
        min-height: 500px;
        padding: 44px 22px;
        border-radius: 24px;
    }

    .oleg-banner::before {
        inset: 7px;
        border-radius: 18px;
    }

    .oleg-banner__emoji {
        font-size: 46px;
    }

    .oleg-banner__sparkle--one {
        left: 5%;
        bottom: 10%;
    }

    .oleg-banner__star--one {
        left: 12%;
    }
}
</style>
