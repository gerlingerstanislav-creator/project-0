<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';

const hydrangeaHeads = [
    { x: 175, y: 145, scale: 1.05, delay: '-1.2s' },
    { x: 305, y: 108, scale: 1.12, delay: '-2.4s' },
    { x: 430, y: 155, scale: 1.02, delay: '-.5s' },
    { x: 235, y: 238, scale: .92, delay: '-3.1s' },
    { x: 365, y: 245, scale: .88, delay: '-1.8s' },
];
</script>

<template>
    <Head title="Ура, Аня приехала!!!" />

    <AppLayout>
        <main class="anya-page">
            <section class="anya-hero" aria-labelledby="anya-title">
                <div class="anya-glow anya-glow--one"></div>
                <div class="anya-glow anya-glow--two"></div>

                <div class="anya-copy">
                    <span class="anya-kicker">💐 SPECIAL DELIVERY 💐</span>
                    <h1 id="anya-title">Ура, Аня<br />приехала!!!</h1>
                    <p>И поэтому здесь просто обязан быть огромный букет.</p>
                </div>

                <div class="bouquet" aria-label="Большой живой букет с гортензиями">
                    <svg class="bouquet-art" viewBox="0 0 600 700" role="img" aria-hidden="true">
                        <defs>
                            <linearGradient id="paper" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0" stop-color="#fff"/>
                                <stop offset=".5" stop-color="#f8edf2"/>
                                <stop offset="1" stop-color="#dfcddc"/>
                            </linearGradient>
                            <linearGradient id="stem" x1="0" x2="1">
                                <stop stop-color="#315f3e"/>
                                <stop offset=".5" stop-color="#76a96d"/>
                                <stop offset="1" stop-color="#3b714b"/>
                            </linearGradient>
                            <linearGradient id="leaf" x1="0" y1="0" x2="1" y2="1">
                                <stop stop-color="#9bc98c"/>
                                <stop offset=".55" stop-color="#4d8b59"/>
                                <stop offset="1" stop-color="#315e42"/>
                            </linearGradient>
                            <radialGradient id="hydrangeaBlue" cx=".35" cy=".28">
                                <stop stop-color="#f1edff"/>
                                <stop offset=".22" stop-color="#c9c1ff"/>
                                <stop offset=".7" stop-color="#8584d8"/>
                                <stop offset="1" stop-color="#6565b5"/>
                            </radialGradient>
                            <radialGradient id="hydrangeaPink" cx=".35" cy=".28">
                                <stop stop-color="#fff1fa"/>
                                <stop offset=".25" stop-color="#f5b9dc"/>
                                <stop offset=".72" stop-color="#d87bb6"/>
                                <stop offset="1" stop-color="#b45b98"/>
                            </radialGradient>
                            <radialGradient id="rose" cx=".35" cy=".25">
                                <stop stop-color="#fff"/>
                                <stop offset=".18" stop-color="#ffc4df"/>
                                <stop offset=".55" stop-color="#ef76ae"/>
                                <stop offset="1" stop-color="#bd4f8d"/>
                            </radialGradient>
                            <filter id="flowerShadow" x="-30%" y="-30%" width="160%" height="160%">
                                <feDropShadow dx="0" dy="7" stdDeviation="6" flood-color="#553d62" flood-opacity=".18"/>
                            </filter>
                            <filter id="soft" x="-30%" y="-30%" width="160%" height="160%">
                                <feGaussianBlur stdDeviation="1.5"/>
                            </filter>
                        </defs>

                        <!-- long, natural stems -->
                        <g class="stems">
                            <path d="M300 620 C275 460 175 280 120 110" stroke="url(#stem)" stroke-width="10" fill="none"/>
                            <path d="M300 620 C285 430 270 250 300 70" stroke="url(#stem)" stroke-width="11" fill="none"/>
                            <path d="M300 620 C320 430 405 270 465 115" stroke="url(#stem)" stroke-width="10" fill="none"/>
                            <path d="M300 620 C315 445 350 350 365 220" stroke="url(#stem)" stroke-width="9" fill="none"/>
                            <path d="M300 620 C270 455 225 390 205 250" stroke="url(#stem)" stroke-width="9" fill="none"/>
                            <path d="M300 620 C340 480 435 400 490 290" stroke="url(#stem)" stroke-width="8" fill="none"/>
                        </g>

                        <!-- foliage behind the flowers -->
                        <g class="foliage">
                            <path d="M188 475 C102 470 65 415 72 356 C137 358 183 393 188 475Z" fill="url(#leaf)"/>
                            <path d="M405 486 C495 478 536 425 528 360 C465 365 420 405 405 486Z" fill="url(#leaf)"/>
                            <path d="M235 555 C151 550 119 500 130 446 C190 449 228 482 235 555Z" fill="url(#leaf)"/>
                            <path d="M370 555 C454 550 490 500 478 445 C420 449 378 482 370 555Z" fill="url(#leaf)"/>
                            <path d="M294 455 C225 430 202 380 220 331 C275 343 301 381 294 455Z" fill="url(#leaf)"/>
                            <path d="M328 455 C396 430 420 380 401 331 C347 343 320 382 328 455Z" fill="url(#leaf)"/>
                        </g>

                        <!-- realistic hydrangea clusters: each cluster is many four-petal florets -->
                        <g
                            v-for="(head, index) in hydrangeaHeads"
                            :key="index"
                            class="hydrangea-head"
                            :style="{ '--head-delay': head.delay, transform: `translate(${head.x}px,${head.y}px) scale(${head.scale})` }"
                        >
                            <g v-for="ring in 4" :key="ring" :transform="`rotate(${ring * 18}) scale(${1 - ring * .045})`">
                                <g v-for="petal in 8" :key="petal" :transform="`rotate(${petal * 45}) translate(0 ${18 + ring * 18})`">
                                    <path class="hydrangea-floret"
                                        :fill="index % 2 === 0 ? 'url(#hydrangeaBlue)' : 'url(#hydrangeaPink)'"
                                        d="M0 -16 C-13 -25 -24 -15 -18 -3 C-24 8 -13 18 0 11 C13 18 24 8 18 -3 C24 -15 13 -25 0 -16Z"/>
                                    <circle cx="0" cy="-3" r="3.2" fill="#fff3a6"/>
                                </g>
                            </g>
                        </g>

                        <!-- roses with curled concentric petals -->
                        <g class="roses" filter="url(#flowerShadow)">
                            <g class="rose-flower rose-flower--one" transform="translate(145 170)">
                                <ellipse rx="61" ry="55" fill="url(#rose)"/>
                                <path d="M-42 3 C-48 -34 -7 -56 26 -39 C55 -24 48 15 23 30 C-5 46 -38 31 -31 8 C-27 -9 2 -22 22 -9 C39 2 26 24 8 20 C-10 16 -8 0 4 -5 C13 -9 18 -1 13 5" fill="none" stroke="#fff0f8" stroke-width="9" stroke-linecap="round"/>
                            </g>
                            <g class="rose-flower rose-flower--two" transform="translate(460 190) scale(.9)">
                                <ellipse rx="61" ry="55" fill="url(#rose)"/>
                                <path d="M-42 3 C-48 -34 -7 -56 26 -39 C55 -24 48 15 23 30 C-5 46 -38 31 -31 8 C-27 -9 2 -22 22 -9 C39 2 26 24 8 20 C-10 16 -8 0 4 -5 C13 -9 18 -1 13 5" fill="none" stroke="#fff0f8" stroke-width="9" stroke-linecap="round"/>
                            </g>
                            <g class="rose-flower rose-flower--three" transform="translate(303 72) scale(.78)">
                                <ellipse rx="61" ry="55" fill="url(#rose)"/>
                                <path d="M-42 3 C-48 -34 -7 -56 26 -39 C55 -24 48 15 23 30 C-5 46 -38 31 -31 8 C-27 -9 2 -22 22 -9 C39 2 26 24 8 20 C-10 16 -8 0 4 -5 C13 -9 18 -1 13 5" fill="none" stroke="#fff0f8" stroke-width="9" stroke-linecap="round"/>
                            </g>
                        </g>

                        <!-- wrapping paper and ribbon -->
                        <g class="wrapper">
                            <path d="M112 500 L488 500 L418 688 L182 688Z" fill="url(#paper)" filter="url(#flowerShadow)"/>
                            <path d="M185 500 L300 688 L414 500" fill="rgba(255,255,255,.45)"/>
                            <path d="M300 500 L300 688" stroke="rgba(160,115,150,.18)" stroke-width="2"/>
                            <path d="M205 518 L250 680 M395 518 L350 680" stroke="rgba(160,115,150,.13)" stroke-width="2"/>
                            <g class="ribbon">
                                <path d="M300 535 C255 505 225 530 246 565 C262 588 283 570 300 552Z" fill="#8d5bd1"/>
                                <path d="M300 535 C345 505 375 530 354 565 C338 588 317 570 300 552Z" fill="#a77be4"/>
                                <path d="M293 553 L246 645 L288 616 L302 565Z" fill="#7546b9"/>
                                <path d="M307 553 L354 645 L312 616 L298 565Z" fill="#8c5ed0"/>
                            </g>
                        </g>

                        <g class="bouquet-sparkles">
                            <circle cx="108" cy="275" r="4" fill="#fff" />
                            <circle cx="493" cy="330" r="5" fill="#fff" />
                            <circle cx="178" cy="95" r="3" fill="#fff" />
                        </g>
                    </svg>
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
    grid-template-columns: minmax(0, .88fr) minmax(480px, 1.12fr);
    align-items: center;
    gap: 8px;
    padding: 48px 36px 26px 56px;
    border-radius: 38px;
    isolation: isolate;
    background:
        radial-gradient(circle at 78% 20%, rgba(255,255,255,.9), transparent 18%),
        radial-gradient(circle at 17% 80%, rgba(224,231,255,.9), transparent 29%),
        linear-gradient(135deg,#fff7fb 0%,#f4edff 48%,#eaf5ff 100%);
    box-shadow: 0 34px 90px rgba(111,76,145,.16), inset 0 1px 0 rgba(255,255,255,.9);
}
.anya-hero::before {
    content:""; position:absolute; inset:12px; border:1px solid rgba(129,93,160,.16);
    border-radius:29px; pointer-events:none; z-index:10;
}
.anya-copy { position:relative; z-index:7; padding:24px 0 80px; }
.anya-kicker {
    display:inline-flex; padding:10px 16px; border:1px solid rgba(146,108,174,.18);
    border-radius:999px; background:rgba(255,255,255,.62); color:#7b4c8f;
    box-shadow:0 10px 30px rgba(119,77,142,.1); backdrop-filter:blur(12px);
    font-size:11px; font-weight:900; letter-spacing:.14em;
}
.anya-copy h1 {
    margin:24px 0 0; color:#42244e; font-size:clamp(54px,7vw,102px);
    line-height:.9; letter-spacing:-.065em; text-wrap:balance;
    text-shadow:0 8px 30px rgba(111,70,130,.12);
}
.anya-copy p {
    max-width:480px; margin:28px 0 0; color:#725e79; font-size:clamp(17px,2vw,21px);
    line-height:1.55; font-weight:600;
}
.anya-glow {
    position:absolute; border-radius:50%; pointer-events:none; filter:blur(8px); z-index:-1;
    animation:glow-drift 8s ease-in-out infinite alternate;
}
.anya-glow--one { width:380px;height:380px;left:-160px;top:-150px;background:rgba(249,168,212,.3); }
.anya-glow--two { width:440px;height:440px;right:-170px;bottom:-190px;background:rgba(165,180,252,.3);animation-delay:-3s; }

.bouquet {
    position:relative; z-index:5; width:min(100%,610px); height:700px; justify-self:center;
    animation:bouquet-breathe 6s ease-in-out infinite; transform-origin:50% 90%;
}
.bouquet-art { width:100%; height:100%; overflow:visible; }
.stems, .foliage, .hydrangea-head, .roses, .wrapper { transform-box:fill-box; transform-origin:center bottom; }
.hydrangea-head { animation:flower-sway 5s ease-in-out infinite; animation-delay:var(--head-delay); }
.hydrangea-floret { filter:drop-shadow(0 3px 3px rgba(73,59,124,.18)); }
.rose-flower { transform-box:fill-box; transform-origin:center; animation:rose-sway 4.5s ease-in-out infinite; }
.rose-flower--two { animation-delay:-1.7s; }
.rose-flower--three { animation-delay:-.8s; }
.foliage { animation:leaf-sway 4.2s ease-in-out infinite; transform-origin:50% 100%; }
.wrapper { transform-origin:50% 100%; }
.ribbo { transform-origin:center; }
.bouquet-sparkles { animation:sparkle 2.7s ease-in-out infinite; }
.anya-sparkle {
    position:absolute; z-index:9; color:#9c72b5; text-shadow:0 4px 15px rgba(112,73,133,.16);
    animation:sparkle 2.7s ease-in-out infinite;
}
.anya-sparkle--one { right:43%; top:12%; font-size:42px; }
.anya-sparkle--two { right:3%; top:43%; font-size:56px; animation-delay:-.9s; }
.anya-sparkle--three { left:51%; bottom:7%; font-size:34px; animation-delay:-1.6s; }

@keyframes bouquet-breathe { 0%,100%{transform:translateY(0) rotate(-.5deg)} 50%{transform:translateY(-10px) rotate(.6deg)} }
@keyframes flower-sway { 0%,100%{transform:rotate(-1deg)} 50%{transform:rotate(1.7deg) translateY(-3px)} }
@keyframes rose-sway { 0%,100%{transform:rotate(-1deg) scale(1)} 50%{transform:rotate(2deg) scale(1.025) translateY(-3px)} }
@keyframes leaf-sway { 0%,100%{transform:rotate(-1deg)} 50%{transform:rotate(1.4deg) translateY(-4px)} }
@keyframes sparkle { 0%,100%{opacity:.35;transform:scale(.85) rotate(0)} 50%{opacity:1;transform:scale(1.15) rotate(12deg)} }
@keyframes glow-drift { from{transform:translate3d(0,0,0) scale(1)} to{transform:translate3d(20px,12px,0) scale(1.08)} }

@media (max-width:900px) {
    .anya-hero { min-height:900px; grid-template-columns:1fr; padding:52px 28px 10px; }
    .anya-copy { padding:18px 0 0; text-align:center; }
    .anya-copy p { margin-left:auto; margin-right:auto; }
    .bouquet { width:min(100%,590px); height:590px; margin-top:-35px; }
    .anya-sparkle--one { right:12%; top:41%; }
    .anya-sparkle--three { left:12%; bottom:5%; }
}
@media (max-width:560px) {
    .anya-page { padding:10px; }
    .anya-hero { min-height:790px; padding:42px 18px 10px; border-radius:24px; }
    .anya-copy h1 { font-size:clamp(45px,14vw,72px); }
    .anya-kicker { font-size:9px; }
    .bouquet { width:540px; height:500px; margin-left:50%; transform:translateX(-50%) scale(.76); transform-origin:50% 50%; margin-top:-65px; }
    .anya-sparkle--one { display:none; }
}
</style>
