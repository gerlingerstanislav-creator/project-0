<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';

const hydrangeas = Array.from({ length: 7 }, (_, index) => index);
const petals = Array.from({ length: 12 }, (_, index) => index);
</script>

<template>
    <Head title="Ура, Аня приехала!!!" />

    <AppLayout>
        <main class="anya-page">
            <section class="anya-hero" aria-labelledby="anya-title">
                <div class="anya-glow anya-glow--one"></div>
                <div class="anya-glow anya-glow--two"></div>
                <div class="anya-confetti" aria-hidden="true">
                    <i v-for="n in 18" :key="n" :class="'anya-confetti__piece anya-confetti__piece--' + n"></i>
                </div>

                <div class="anya-copy">
                    <span class="anya-kicker">💐 SPECIAL DELIVERY 💐</span>
                    <h1 id="anya-title">Ура, Аня<br />приехала!!!</h1>
                    <p>И поэтому здесь просто обязан быть огромный букет.</p>
                </div>

                <div class="bouquet" aria-label="Большой букет цветов с гортензиями">
                    <div class="bouquet__back-ribbon bouquet__back-ribbon--left"></div>
                    <div class="bouquet__back-ribbon bouquet__back-ribbon--right"></div>

                    <div
                        v-for="(hydrangea, flowerIndex) in hydrangeas"
                        :key="'hydrangea-' + hydrangea"
                        class="hydrangea"
                        :class="'hydrangea--' + flowerIndex"
                    >
                        <span
                            v-for="petal in petals"
                            :key="petal"
                            class="hydrangea__petal"
                            :style="{ '--petal': petal }"
                        ></span>
                        <span class="hydrangea__center"></span>
                    </div>

                    <div class="rose rose--one">
                        <span v-for="n in 8" :key="n" class="rose__petal"></span>
                    </div>
                    <div class="rose rose--two">
                        <span v-for="n in 8" :key="n" class="rose__petal"></span>
                    </div>
                    <div class="rose rose--three">
                        <span v-for="n in 8" :key="n" class="rose__petal"></span>
                    </div>

                    <div class="bouquet__stems">
                        <span v-for="n in 12" :key="n" class="stem" :class="'stem--' + n"></span>
                    </div>

                    <div class="bouquet__leaves">
                        <span v-for="n in 10" :key="n" class="leaf" :class="'leaf--' + n"></span>
                    </div>

                    <div class="bouquet__paper">
                        <div class="bouquet__paper-fold"></div>
                        <div class="bouquet__paper-shadow"></div>
                    </div>

                    <div class="bouquet__ribbon">
                        <span class="bouquet__knot"></span>
                        <span class="bouquet__tail bouquet__tail--left"></span>
                        <span class="bouquet__tail bouquet__tail--right"></span>
                    </div>
                </div>

                <div class="anya-sparkle anya-sparkle--one">✦</div>
                <div class="anya-sparkle anya-sparkle--two">✧</div>
                <div class="anya-sparkle anya-sparkle--three">✦</div>
            </section>
        </main>
    </AppLayout>
</template>

<style scoped>
.anya-page {
    min-height: calc(100vh - 96px);
    display: grid;
    place-items: center;
    padding: 24px;
}

.anya-hero {
    position: relative;
    width: min(100%, 1180px);
    min-height: 760px;
    overflow: hidden;
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(420px, 1fr);
    align-items: center;
    gap: 18px;
    padding: 64px 56px 40px;
    border-radius: 38px;
    isolation: isolate;
    background:
        radial-gradient(circle at 74% 18%, rgba(255, 255, 255, .8), transparent 16%),
        radial-gradient(circle at 20% 78%, rgba(224, 231, 255, .9), transparent 28%),
        linear-gradient(135deg, #fff7fb 0%, #f4edff 48%, #eaf5ff 100%);
    box-shadow:
        0 34px 90px rgba(111, 76, 145, .16),
        inset 0 1px 0 rgba(255, 255, 255, .9);
}

.anya-hero::before {
    content: "";
    position: absolute;
    inset: 12px;
    border: 1px solid rgba(129, 93, 160, .16);
    border-radius: 29px;
    pointer-events: none;
    z-index: 10;
}

.anya-copy {
    position: relative;
    z-index: 7;
    padding: 24px 0 80px;
}

.anya-kicker {
    display: inline-flex;
    align-items: center;
    padding: 10px 16px;
    border: 1px solid rgba(146, 108, 174, .18);
    border-radius: 999px;
    background: rgba(255, 255, 255, .62);
    color: #7b4c8f;
    box-shadow: 0 10px 30px rgba(119, 77, 142, .1);
    backdrop-filter: blur(12px);
    font-size: 11px;
    font-weight: 900;
    letter-spacing: .14em;
}

.anya-copy h1 {
    margin: 24px 0 0;
    color: #42244e;
    font-size: clamp(54px, 7vw, 102px);
    line-height: .9;
    letter-spacing: -.065em;
    text-wrap: balance;
    text-shadow: 0 8px 30px rgba(111, 70, 130, .12);
}

.anya-copy p {
    max-width: 480px;
    margin: 28px 0 0;
    color: #725e79;
    font-size: clamp(17px, 2vw, 21px);
    line-height: 1.55;
    font-weight: 600;
}

.anya-glow {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
    filter: blur(8px);
    z-index: -1;
    animation: glow-drift 8s ease-in-out infinite alternate;
}

.anya-glow--one {
    width: 380px;
    height: 380px;
    left: -160px;
    top: -150px;
    background: rgba(249, 168, 212, .3);
}

.anya-glow--two {
    width: 440px;
    height: 440px;
    right: -170px;
    bottom: -190px;
    background: rgba(165, 180, 252, .3);
    animation-delay: -3s;
}

.bouquet {
    position: relative;
    z-index: 5;
    width: min(100%, 560px);
    height: 620px;
    justify-self: center;
    animation: bouquet-breathe 5.5s ease-in-out infinite;
    transform-origin: 50% 90%;
}

.hydrangea,
.rose,
.bouquet__stems,
.bouquet__leaves,
.bouquet__paper,
.bouquet__ribbon,
.bouquet__back-ribbon {
    position: absolute;
}

.hydrangea {
    width: 190px;
    height: 190px;
    border-radius: 50%;
    animation: flower-sway 4.5s ease-in-out infinite;
    transform-origin: 50% 80%;
}

.hydrangea--0 { left: 46px; top: 70px; animation-delay: -.4s; }
.hydrangea--1 { left: 182px; top: 30px; animation-delay: -1.1s; }
.hydrangea--2 { right: 28px; top: 92px; animation-delay: -2s; }
.hydrangea--3 { left: 112px; top: 180px; animation-delay: -2.8s; transform: scale(.96); }
.hydrangea--4 { right: 94px; top: 205px; animation-delay: -3.4s; transform: scale(.92); }
.hydrangea--5 { left: 12px; top: 222px; animation-delay: -1.8s; transform: scale(.78); }
.hydrangea--6 { right: -8px; top: 230px; animation-delay: -2.5s; transform: scale(.76); }

.hydrangea__petal {
    position: absolute;
    left: 50%;
    top: 50%;
    width: 54px;
    height: 54px;
    margin: -27px;
    border-radius: 45% 55% 48% 52%;
    background:
        radial-gradient(circle at 35% 30%, rgba(255,255,255,.9), transparent 16%),
        linear-gradient(145deg, #c4b5fd, #8b8ce8 58%, #6d6bc5);
    box-shadow:
        inset -5px -7px 10px rgba(67, 56, 140, .15),
        0 5px 9px rgba(98, 79, 160, .12);
    transform: rotate(calc(var(--petal) * 30deg)) translateY(-45px) rotate(calc(var(--petal) * -30deg));
    transform-origin: center;
    animation: petal-pulse 3.2s ease-in-out infinite;
    animation-delay: calc(var(--petal) * -0.09s);
}

.hydrangea__center {
    position: absolute;
    left: 50%;
    top: 50%;
    width: 13px;
    height: 13px;
    margin: -6px;
    border-radius: 50%;
    background: #fff4b8;
    box-shadow: 0 0 0 5px rgba(255, 255, 255, .24);
    animation: center-glow 2.4s ease-in-out infinite;
}

.rose {
    width: 112px;
    height: 112px;
    border-radius: 50%;
    z-index: 4;
    animation: rose-sway 4s ease-in-out infinite;
}

.rose--one { left: 98px; top: 104px; animation-delay: -.8s; }
.rose--two { right: 88px; top: 132px; animation-delay: -2.2s; transform: scale(.9); }
.rose--three { left: 218px; top: 8px; animation-delay: -1.4s; transform: scale(.78); }

.rose__petal {
    position: absolute;
    left: 50%;
    top: 50%;
    width: 66px;
    height: 66px;
    margin: -33px;
    border-radius: 54% 46% 58% 42%;
    background: radial-gradient(circle at 35% 30%, #fff 0 5%, #f9a8d4 25%, #e879b5 70%, #c95d9c 100%);
    box-shadow: inset -4px -6px 9px rgba(135, 42, 100, .13);
    transform: rotate(calc(var(--rose-petal) * 45deg)) translateY(-19px) rotate(calc(var(--rose-petal) * -45deg));
}

.rose__petal:nth-child(1) { --rose-petal: 0; }
.rose__petal:nth-child(2) { --rose-petal: 1; }
.rose__petal:nth-child(3) { --rose-petal: 2; }
.rose__petal:nth-child(4) { --rose-petal: 3; }
.rose__petal:nth-child(5) { --rose-petal: 4; }
.rose__petal:nth-child(6) { --rose-petal: 5; }
.rose__petal:nth-child(7) { --rose-petal: 6; }
.rose__petal:nth-child(8) { --rose-petal: 7; }

.bouquet__stems {
    left: 48px;
    top: 178px;
    width: 420px;
    height: 350px;
    z-index: 1;
}

.stem {
    position: absolute;
    left: 50%;
    top: 0;
    width: 9px;
    height: 350px;
    border-radius: 999px;
    background: linear-gradient(90deg, #4d8c64, #7eb47e 55%, #3e7554);
    transform-origin: 50% 0;
}

.stem--1 { transform: rotate(-28deg); }
.stem--2 { transform: rotate(-21deg); }
.stem--3 { transform: rotate(-14deg); }
.stem--4 { transform: rotate(-8deg); }
.stem--5 { transform: rotate(-3deg); }
.stem--6 { transform: rotate(4deg); }
.stem--7 { transform: rotate(10deg); }
.stem--8 { transform: rotate(16deg); }
.stem--9 { transform: rotate(22deg); }
.stem--10 { transform: rotate(28deg); }
.stem--11 { transform: rotate(-34deg); }
.stem--12 { transform: rotate(34deg); }

.bouquet__leaves {
    inset: 190px 40px auto;
    height: 280px;
    z-index: 2;
}

.leaf {
    position: absolute;
    width: 80px;
    height: 38px;
    border-radius: 100% 0 100% 0;
    background: linear-gradient(145deg, #91c78f, #4e9166);
    box-shadow: inset -8px -5px 9px rgba(44, 87, 60, .15);
    transform-origin: 0 50%;
    animation: leaf-sway 3.8s ease-in-out infinite;
}

.leaf::after {
    content: "";
    position: absolute;
    left: 8px;
    right: 8px;
    top: 18px;
    height: 2px;
    border-radius: 999px;
    background: rgba(238, 255, 224, .48);
    transform: rotate(-8deg);
}

.leaf--1 { left: 22px; top: 34px; transform: rotate(22deg); }
.leaf--2 { left: 68px; top: 112px; transform: rotate(-28deg) scale(.9); animation-delay: -.7s; }
.leaf--3 { left: 2px; top: 188px; transform: rotate(35deg) scale(.82); animation-delay: -1.1s; }
.leaf--4 { right: 10px; top: 52px; transform: scaleX(-1) rotate(26deg); animation-delay: -.3s; }
.leaf--5 { right: 50px; top: 128px; transform: scaleX(-1) rotate(-24deg) scale(.9); animation-delay: -1.5s; }
.leaf--6 { right: 0; top: 208px; transform: scaleX(-1) rotate(32deg) scale(.82); animation-delay: -2s; }
.leaf--7 { left: 140px; top: 222px; transform: rotate(18deg) scale(.75); animation-delay: -.9s; }
.leaf--8 { right: 134px; top: 232px; transform: scaleX(-1) rotate(16deg) scale(.75); animation-delay: -1.8s; }
.leaf--9 { left: 178px; top: 70px; transform: rotate(-20deg) scale(.65); animation-delay: -2.3s; }
.leaf--10 { right: 176px; top: 78px; transform: scaleX(-1) rotate(-17deg) scale(.65); animation-delay: -2.8s; }

.bouquet__paper {
    left: 82px;
    bottom: 22px;
    width: 390px;
    height: 220px;
    z-index: 6;
    overflow: hidden;
    clip-path: polygon(4% 4%, 96% 4%, 78% 100%, 22% 100%);
    background: linear-gradient(115deg, #fff 0%, #f9eef4 48%, #e9dce8 100%);
    filter: drop-shadow(0 18px 18px rgba(92, 59, 83, .16));
    transform: rotate(-2deg);
}

.bouquet__paper::before,
.bouquet__paper::after {
    content: "";
    position: absolute;
    top: -10%;
    width: 2px;
    height: 120%;
    background: rgba(178, 132, 165, .22);
    transform: rotate(17deg);
}

.bouquet__paper::before { left: 26%; }
.bouquet__paper::after { right: 25%; transform: rotate(-17deg); }

.bouquet__paper-fold {
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent 42%, rgba(255,255,255,.62) 50%, transparent 58%);
}

.bouquet__paper-shadow {
    position: absolute;
    inset: auto 0 0;
    height: 55px;
    background: linear-gradient(transparent, rgba(132, 88, 122, .12));
}

.bouquet__ribbon {
    left: 218px;
    bottom: 56px;
    z-index: 8;
}

.bouquet__knot {
    display: block;
    width: 74px;
    height: 45px;
    border-radius: 50% 50% 45% 45%;
    background: linear-gradient(145deg, #c084fc, #8b5cf6);
    box-shadow: 0 8px 15px rgba(109, 62, 166, .22);
}

.bouquet__tail {
    position: absolute;
    top: 26px;
    width: 78px;
    height: 125px;
    background: linear-gradient(145deg, #a78bfa, #7c3aed);
    clip-path: polygon(10% 0, 100% 0, 75% 100%, 48% 83%, 20% 100%);
    transform-origin: top center;
}

.bouquet__tail--left { right: 45px; transform: rotate(17deg); }
.bouquet__tail--right { left: 45px; transform: scaleX(-1) rotate(17deg); }

.bouquet__back-ribbon {
    z-index: 0;
    width: 160px;
    height: 300px;
    bottom: 62px;
    border-radius: 30px;
    background: linear-gradient(145deg, rgba(196, 181, 253, .65), rgba(124, 58, 237, .45));
    filter: blur(.2px);
}

.bouquet__back-ribbon--left {
    left: 92px;
    transform: rotate(24deg);
}

.bouquet__back-ribbon--right {
    right: 72px;
    transform: rotate(-24deg);
}

.anya-sparkle {
    position: absolute;
    z-index: 9;
    color: #9c72b5;
    text-shadow: 0 4px 15px rgba(112, 73, 133, .16);
    animation: sparkle 2.7s ease-in-out infinite;
}

.anya-sparkle--one { right: 46%; top: 13%; font-size: 42px; }
.anya-sparkle--two { right: 5%; top: 42%; font-size: 56px; animation-delay: -.9s; }
.anya-sparkle--three { left: 49%; bottom: 9%; font-size: 34px; animation-delay: -1.6s; }

.anya-confetti {
    position: absolute;
    inset: 0;
    z-index: 2;
    pointer-events: none;
}

.anya-confetti__piece {
    position: absolute;
    width: 8px;
    height: 22px;
    border-radius: 99px;
    opacity: .5;
    animation: confetti-float 4s ease-in-out infinite;
}

.anya-confetti__piece--1 { left: 7%; top: 16%; background: #e879f9; transform: rotate(32deg); }
.anya-confetti__piece--2 { left: 15%; top: 78%; background: #818cf8; transform: rotate(-28deg); animation-delay: -.8s; }
.anya-confetti__piece--3 { left: 28%; top: 8%; background: #f472b6; transform: rotate(62deg); animation-delay: -1.4s; }
.anya-confetti__piece--4 { left: 42%; top: 20%; background: #a78bfa; transform: rotate(-24deg); animation-delay: -2.1s; }
.anya-confetti__piece--5 { left: 52%; top: 84%; background: #60a5fa; transform: rotate(50deg); animation-delay: -1.1s; }
.anya-confetti__piece--6 { left: 67%; top: 9%; background: #f9a8d4; transform: rotate(-42deg); animation-delay: -2.7s; }
.anya-confetti__piece--7 { left: 81%; top: 68%; background: #8b5cf6; transform: rotate(22deg); animation-delay: -.4s; }
.anya-confetti__piece--8 { left: 93%; top: 24%; background: #93c5fd; transform: rotate(68deg); animation-delay: -1.9s; }
.anya-confetti__piece--9 { left: 4%; top: 45%; background: #f0abfc; transform: rotate(-54deg); animation-delay: -3s; }
.anya-confetti__piece--10 { left: 24%; top: 91%; background: #c4b5fd; transform: rotate(38deg); animation-delay: -1.6s; }
.anya-confetti__piece--11 { left: 37%; top: 66%; background: #f9a8d4; transform: rotate(-68deg); animation-delay: -2.5s; }
.anya-confetti__piece--12 { left: 58%; top: 12%; background: #93c5fd; transform: rotate(44deg); animation-delay: -3.3s; }
.anya-confetti__piece--13 { left: 73%; top: 90%; background: #c4b5fd; transform: rotate(-32deg); animation-delay: -2.2s; }
.anya-confetti__piece--14 { left: 87%; top: 51%; background: #f9a8d4; transform: rotate(58deg); animation-delay: -1.2s; }
.anya-confetti__piece--15 { left: 34%; top: 35%; background: #a5b4fc; transform: rotate(-19deg); animation-delay: -2.8s; }
.anya-confetti__piece--16 { left: 63%; top: 54%; background: #f0abfc; transform: rotate(31deg); animation-delay: -.7s; }
.anya-confetti__piece--17 { left: 12%; top: 28%; background: #93c5fd; transform: rotate(-45deg); animation-delay: -1.8s; }
.anya-confetti__piece--18 { left: 77%; top: 31%; background: #f472b6; transform: rotate(73deg); animation-delay: -3.5s; }

@keyframes bouquet-breathe {
    0%, 100% { transform: translateY(0) rotate(-.5deg); }
    50% { transform: translateY(-10px) rotate(.7deg); }
}

@keyframes flower-sway {
    0%, 100% { transform: rotate(-1deg); }
    50% { transform: rotate(2deg) translateY(-3px); }
}

@keyframes rose-sway {
    0%, 100% { rotate: -1deg; }
    50% { rotate: 2deg; translate: 0 -3px; }
}

@keyframes petal-pulse {
    0%, 100% { filter: brightness(1); }
    50% { filter: brightness(1.12); }
}

@keyframes center-glow {
    0%, 100% { box-shadow: 0 0 0 5px rgba(255,255,255,.2); }
    50% { box-shadow: 0 0 0 9px rgba(255,255,255,.34); }
}

@keyframes leaf-sway {
    0%, 100% { margin-top: 0; }
    50% { margin-top: -4px; }
}

@keyframes sparkle {
    0%, 100% { opacity: .35; transform: scale(.85) rotate(0); }
    50% { opacity: 1; transform: scale(1.15) rotate(12deg); }
}

@keyframes confetti-float {
    0%, 100% { translate: 0 0; }
    50% { translate: 0 -10px; }
}

@keyframes glow-drift {
    from { transform: translate3d(0, 0, 0) scale(1); }
    to { transform: translate3d(20px, 12px, 0) scale(1.08); }
}

@media (max-width: 900px) {
    .anya-hero {
        min-height: 900px;
        grid-template-columns: 1fr;
        padding: 52px 28px 20px;
    }

    .anya-copy {
        padding: 18px 0 0;
        text-align: center;
    }

    .anya-copy p {
        margin-left: auto;
        margin-right: auto;
    }

    .bouquet {
        width: min(100%, 520px);
        height: 520px;
        transform: scale(.86);
        margin-top: -38px;
    }

    .anya-sparkle--one { right: 12%; top: 41%; }
    .anya-sparkle--three { left: 12%; bottom: 5%; }
}

@media (max-width: 560px) {
    .anya-page {
        padding: 10px;
    }

    .anya-hero {
        min-height: 790px;
        padding: 42px 18px 10px;
        border-radius: 24px;
    }

    .anya-copy h1 {
        font-size: clamp(45px, 14vw, 72px);
    }

    .anya-kicker {
        font-size: 9px;
    }

    .bouquet {
        width: 440px;
        height: 470px;
        margin-left: 50%;
        transform: translateX(-50%) scale(.67);
        transform-origin: 50% 50%;
        margin-top: -70px;
    }

    .anya-sparkle--one { display: none; }
}
</style>
