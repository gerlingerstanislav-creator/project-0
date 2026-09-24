<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';
import PageHeader from '../components/ui/PageHeader.vue';

const ip = ref('');
const loading = ref(false);
const error = ref('');
const result = ref(null);

async function checkIp() {
    error.value = '';
    result.value = null;
    loading.value = true;

    try {
        const response = await fetch('/check-ip/lookup', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
            },
            body: JSON.stringify({ ip: ip.value.trim() }),
        });
        const data = await response.json();
        if (!response.ok) {
            throw new Error(data?.message || data?.errors?.ip?.[0] || 'Не удалось проверить IP.');
        }
        result.value = data;
    } catch (e) {
        error.value = e.message || 'Не удалось проверить IP.';
    } finally {
        loading.value = false;
    }
}

function value(value) {
    if (Array.isArray(value)) return value.length ? value.join(', ') : 'N/A';
    return value === null || value === undefined || value === '' ? 'N/A' : value;
}

function formatEvent(event) {
    return [event.eventAction, event.eventDate].filter(Boolean).join(' · ');
}
</script>

<template>
    <Head title="Check IP" />
    <AppLayout>
        <main class="check-ip">
            <PageHeader eyebrow="NETWORK TOOL" title="Check IP" description="Избыточный паспорт IP-адреса: тип, reverse DNS, представления адреса и регистрационные данные RDAP." />

            <section class="search-card">
                <form class="search-form" @submit.prevent="checkIp">
                    <label for="ip">IPv4 или IPv6</label>
                    <div class="search-row">
                        <input id="ip" v-model="ip" class="ds-input ip-input" autocomplete="off" spellcheck="false" placeholder="8.8.8.8 или 2001:4860:4860::8888" />
                        <button class="ds-button" type="submit" :disabled="loading || !ip.trim()">{{ loading ? 'Проверяем…' : 'Проверить' }}</button>
                    </div>
                    <p class="hint">Проверка выполняется с сервера project-0. Для публичных адресов дополнительно запрашивается RDAP.</p>
                </form>
            </section>

            <div v-if="error" class="error-box">{{ error }}</div>

            <template v-if="result">
                <section class="summary">
                    <div><span>IP</span><strong>{{ result.ip }}</strong></div>
                    <div><span>Версия</span><strong>{{ result.version }}</strong></div>
                    <div><span>Scope</span><strong>{{ result.scope }}</strong></div>
                    <div><span>PTR / reverse DNS</span><strong>{{ value(result.ptr) }}</strong></div>
                </section>

                <div class="grid">
                    <section class="panel">
                        <h2>Представления адреса</h2>
                        <dl>
                            <div><dt>Decimal</dt><dd>{{ value(result.decimal) }}</dd></div>
                            <div><dt>Hex</dt><dd class="mono">{{ value(result.hex) }}</dd></div>
                            <div><dt>Binary</dt><dd class="mono wrap">{{ value(result.binary) }}</dd></div>
                        </dl>
                    </section>

                    <section class="panel">
                        <h2>Network / RDAP</h2>
                        <dl v-if="result.rdap">
                            <div><dt>Network name</dt><dd>{{ value(result.rdap.name) }}</dd></div>
                            <div><dt>Handle</dt><dd>{{ value(result.rdap.handle) }}</dd></div>
                            <div><dt>Type</dt><dd>{{ value(result.rdap.type) }}</dd></div>
                            <div><dt>Range</dt><dd>{{ value(result.rdap.startAddress) }} — {{ value(result.rdap.endAddress) }}</dd></div>
                            <div><dt>Country</dt><dd>{{ value(result.rdap.country) }}</dd></div>
                            <div><dt>Parent</dt><dd>{{ value(result.rdap.parentHandle) }}</dd></div>
                            <div><dt>WHOIS server</dt><dd>{{ value(result.rdap.port43) }}</dd></div>
                            <div><dt>Status</dt><dd>{{ value(result.rdap.status) }}</dd></div>
                        </dl>
                        <p v-else class="muted">{{ result.rdap_error }}</p>
                    </section>

                    <section v-if="result.rdap" class="panel">
                        <h2>Контакты и роли</h2>
                        <div v-if="result.rdap.entities.length" class="entity-list">
                            <article v-for="entity in result.rdap.entities" :key="entity.handle || entity.name" class="entity">
                                <strong>{{ value(entity.name || entity.handle) }}</strong>
                                <span>{{ value(entity.roles) }}</span>
                                <span>{{ value(entity.email) }}</span>
                                <span>{{ value(entity.phone) }}</span>
                            </article>
                        </div>
                        <p v-else class="muted">Контакты в ответе RDAP отсутствуют.</p>
                    </section>

                    <section v-if="result.rdap" class="panel">
                        <h2>События регистрации</h2>
                        <ul v-if="result.rdap.events.length" class="event-list">
                            <li v-for="event in result.rdap.events" :key="formatEvent(event)">{{ formatEvent(event) }}</li>
                        </ul>
                        <p v-else class="muted">События отсутствуют.</p>
                    </section>
                </div>

                <section v-if="result.rdap" class="panel raw-panel">
                    <details>
                        <summary>Raw RDAP JSON</summary>
                        <pre>{{ JSON.stringify(result.rdap.raw, null, 2) }}</pre>
                    </details>
                </section>
            </template>
        </main>
    </AppLayout>
</template>

<style scoped>
.check-ip{max-width:1280px;margin:0 auto;padding:28px 28px 56px}.search-card,.panel,.summary{border:1px solid var(--ds-border,#e7e0eb);background:#fff;border-radius:22px;box-shadow:0 8px 30px #4d36500a}.search-card{padding:24px;margin:24px 0}.search-form label{display:block;margin-bottom:9px;font-size:13px;font-weight:800;color:#392a43}.search-row{display:flex;gap:12px}.ip-input{flex:1;min-width:0;font-family:ui-monospace,SFMono-Regular,Menlo,monospace}.hint,.muted{margin:10px 0 0;color:#817486;font-size:13px;line-height:1.5}.error-box{margin:16px 0;padding:14px 18px;border:1px solid #efb8b8;border-radius:14px;background:#fff5f5;color:#8a2424}.summary{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));overflow:hidden;margin-bottom:16px}.summary div{padding:20px;border-right:1px solid #eee8f0}.summary div:last-child{border:0}.summary span{display:block;margin-bottom:6px;color:#8b7c90;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.08em}.summary strong{display:block;color:#2d2035;font-size:15px;overflow-wrap:anywhere}.grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}.panel{padding:24px;min-width:0}.panel h2{margin:0 0 18px;color:#2c2034;font-size:19px}.panel dl{margin:0}.panel dl>div{display:grid;grid-template-columns:150px 1fr;gap:18px;padding:10px 0;border-bottom:1px solid #f0ebf2}.panel dl>div:last-child{border-bottom:0}.panel dt{color:#8b7c90;font-size:12px}.panel dd{margin:0;color:#34273b;font-size:13px;overflow-wrap:anywhere}.mono{font-family:ui-monospace,SFMono-Regular,Menlo,monospace}.wrap{word-break:break-all}.entity-list{display:grid;gap:10px}.entity{display:grid;gap:4px;padding:13px 15px;border-radius:14px;background:#f8f5f9}.entity strong{font-size:13px}.entity span{font-size:12px;color:#766a7a;overflow-wrap:anywhere}.event-list{margin:0;padding-left:20px;color:#55465b;font-size:13px;line-height:1.8}.raw-panel{margin-top:16px}.raw-panel summary{cursor:pointer;font-weight:800;color:#392a43}.raw-panel pre{max-height:520px;overflow:auto;margin:18px 0 0;padding:18px;border-radius:14px;background:#211929;color:#eee5f2;font-size:11px;line-height:1.55;white-space:pre-wrap;word-break:break-word}
@media(max-width:850px){.summary{grid-template-columns:repeat(2,minmax(0,1fr))}.summary div:nth-child(2){border-right:0}.summary div:nth-child(-n+2){border-bottom:1px solid #eee8f0}.grid{grid-template-columns:1fr}}
@media(max-width:600px){.check-ip{padding:16px 12px 36px}.search-card,.panel{padding:18px;border-radius:18px}.search-row{flex-direction:column}.summary{grid-template-columns:1fr}.summary div{border-right:0;border-bottom:1px solid #eee8f0!important}.summary div:last-child{border-bottom:0!important}.panel dl>div{grid-template-columns:1fr;gap:4px}}
</style>
