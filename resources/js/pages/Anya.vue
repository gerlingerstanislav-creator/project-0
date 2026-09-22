<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';

const flowerSources = {
    pink: 'https://wallpapers.com/images/hd/pink-hydrangea-bloom-transparent-background-shaxv0ufousimvye.png',
    blue: 'https://commons.wikimedia.org/wiki/Special:Redirect/file/Hydrangea.png',
    white: 'https://commons.wikimedia.org/wiki/Special:Redirect/file/Hydrangea.png',
};
const flowers = [
    ['8%','13%','30%','-10deg','-1s','pink'],['28%','2%','34%','4deg','-2.6s','blue'],
    ['55%','6%','33%','9deg','-1.8s','pink'],['69%','20%','29%','13deg','-.4s','blue'],
    ['2%','38%','33%','-13deg','-2.2s','blue'],['23%','27%','37%','-3deg','-1.4s','pink'],
    ['47%','27%','38%','5deg','-3.7s','white'],['69%','39%','33%','11deg','-.8s','pink'],
    ['12%','51%','34%','-8deg','-3s','white'],['37%','48%','39%','1deg','-1.1s','blue'],
    ['61%','51%','35%','8deg','-2.5s','pink'],
];
</script>

<template>
    <Head title="Ура, Аня приехала!!!" />
    <AppLayout>
        <main class="anya-page">
            <section class="anya-hero" aria-labelledby="anya-title">
                <div class="glow glow--one"></div><div class="glow glow--two"></div>
                <div class="bouquet" aria-label="Большой живой букет гортензий">
                    <div class="stems" aria-hidden="true"><i v-for="n in 8" :key="n" :style="{ '--n': n }"></i></div>
                    <div v-for="(f,i) in flowers" :key="i" class="flower"
                        :class="`flower--${f[5]}`"
                        :style="{left:f[0],top:f[1],width:f[2],'--r':f[3],'--d':f[4]}">
                        <img :src="flowerSources[f[5]]" alt="" aria-hidden="true" loading="eager">
                    </div>
                    <div class="leaves" aria-hidden="true"><i v-for="n in 9" :key="n" :style="{ '--n': n }"></i></div>
                    <div class="wrap" aria-hidden="true"><span class="paper"></span><span class="bow"></span><span class="tail tail--l"></span><span class="tail tail--r"></span></div>
                </div>
                <h1 id="anya-title">Ура, Аня приехала!!!</h1>
            </section>
        </main>
    </AppLayout>
</template>

<style scoped>
.anya-page{min-height:calc(100vh - 96px);display:grid;place-items:center;padding:12px 18px 26px}
.anya-hero{position:relative;width:min(100%,1120px);min-height:calc(100vh - 126px);display:flex;flex-direction:column;align-items:center;justify-content:center;overflow:hidden;padding:10px 20px 28px;border-radius:38px;isolation:isolate;background:radial-gradient(circle at 50% 17%,#fff 0,transparent 25%),radial-gradient(circle at 15% 80%,#fac6e180,transparent 30%),radial-gradient(circle at 88% 70%,#bacbff80,transparent 31%),linear-gradient(145deg,#fff9fc,#f5efff 52%,#eef7ff);box-shadow:0 34px 90px #6f4c9126,inset 0 1px #fff}
.anya-hero:before{content:"";position:absolute;inset:12px;border:1px solid #815da01f;border-radius:29px;pointer-events:none}
.glow{position:absolute;border-radius:50%;filter:blur(12px);z-index:-1;animation:glow 10s ease-in-out infinite alternate}.glow--one{width:340px;height:340px;left:-130px;top:-130px;background:#f9a8d43d}.glow--two{width:390px;height:390px;right:-150px;bottom:-170px;background:#a5b4fc3d;animation-delay:-4s}
.bouquet{position:relative;width:min(72vw,760px);height:min(67vh,690px);min-height:480px;flex:none;animation:breathe 7s ease-in-out infinite;transform-origin:50% 88%}
.flower{position:absolute;aspect-ratio:1;z-index:3;transform-origin:50% 88%;animation:sway 5.8s ease-in-out infinite;animation-delay:var(--d);will-change:transform}
.flower img{width:100%;height:100%;display:block;object-fit:contain;filter:drop-shadow(0 14px 14px #4e315c26);transform:scale(1.08)}
.flower--blue img{filter:hue-rotate(155deg) saturate(1.12) drop-shadow(0 14px 14px #4e315c26)}
.flower--white img{filter:grayscale(1) brightness(1.5) saturate(.1) drop-shadow(0 14px 14px #4e315c26)}
.stems{position:absolute;left:50%;bottom:8%;width:34%;height:58%;transform:translateX(-50%);z-index:1}.stems i{position:absolute;left:50%;bottom:0;width:9px;height:100%;border-radius:999px;transform-origin:50% 100%;transform:translateX(-50%) rotate(calc(var(--n)*9deg - 40deg));background:linear-gradient(90deg,#315d3d,#79a86d 48%,#3b704b);opacity:.88;animation:stem 5s ease-in-out infinite;animation-delay:calc(var(--n)*-.23s)}
.leaves{position:absolute;inset:22% 5% 7%;z-index:2}.leaves i{position:absolute;width:22%;height:13%;left:calc((var(--n) - 1)*10%);top:calc(40% + (var(--n) % 3)*10%);border-radius:100% 0;background:linear-gradient(135deg,#a7ce94,#477c52 72%);transform:rotate(calc(-42deg + var(--n)*13deg));box-shadow:inset -7px -6px 12px #1c452726;animation:leaf 4.8s ease-in-out infinite;animation-delay:calc(var(--n)*-.37s)}
.wrap{position:absolute;z-index:8;left:50%;bottom:-1%;width:48%;height:34%;transform:translateX(-50%);filter:drop-shadow(0 18px 18px #45304b1f)}.paper{position:absolute;inset:0;clip-path:polygon(8% 0,92% 0,76% 100%,24% 100%);background:linear-gradient(105deg,#fff,#f8edf3 48%,#dfcddd)}.bow{position:absolute;left:50%;top:4%;width:22%;height:16%;border-radius:80% 12%;background:linear-gradient(135deg,#b18ae8,#7045ae);transform:translateX(-94%) rotate(28deg);animation:bow 4s ease-in-out infinite}.tail{position:absolute;top:12%;height:52%;width:9%;border-radius:8px;background:#7045ae}.tail--l{left:41%;transform:rotate(25deg)}.tail--r{right:41%;transform:rotate(-25deg)}
.anya-hero>h1{position:relative;z-index:20;margin:0;color:#42244e;font-size:clamp(42px,5.7vw,78px);line-height:.95;letter-spacing:-.055em;text-align:center;text-shadow:0 8px 30px #6f46801f}
@keyframes breathe{0%,100%{transform:translateY(0) rotate(-.45deg)}50%{transform:translateY(-9px) rotate(.55deg)}}@keyframes sway{0%,100%{transform:rotate(calc(var(--r) - 1.2deg))}50%{transform:rotate(calc(var(--r) + 1.5deg)) translateY(-7px) scale(1.015)}}@keyframes stem{0%,100%{transform:translateX(-50%) rotate(calc(var(--n)*9deg - 40deg))}50%{transform:translateX(-50%) rotate(calc(var(--n)*9deg - 38deg))}}@keyframes leaf{0%,100%{transform:rotate(calc(-42deg + var(--n)*13deg))}50%{transform:rotate(calc(-39deg + var(--n)*13deg)) translateY(-3px)}}@keyframes bow{50%{transform:translateX(-94%) rotate(31deg) scale(1.035)}}@keyframes glow{to{transform:translate3d(20px,12px,0) scale(1.08)}}
@media(max-width:900px){.anya-page{padding:8px}.anya-hero{min-height:calc(100vh - 112px);border-radius:26px;padding:18px 12px 24px}.bouquet{width:min(96vw,690px);height:min(68vh,600px);min-height:420px}.anya-hero>h1{font-size:clamp(40px,8vw,64px)}}@media(max-width:560px){.anya-hero{min-height:calc(100vh - 108px)}.bouquet{width:112vw;height:57vh;min-height:390px}.anya-hero>h1{font-size:clamp(38px,11vw,54px)}}@media(prefers-reduced-motion:reduce){.bouquet,.flower,.stems i,.leaves i,.bow,.glow{animation:none}}
</style>