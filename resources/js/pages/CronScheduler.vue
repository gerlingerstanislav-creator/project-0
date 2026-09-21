<script setup>
import { computed, ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '../layouts/AppLayout.vue';
import PageHeader from '../components/ui/PageHeader.vue';

const mode = ref('builder');
const preset = ref('daily');
const time = ref('09:00');
const weekday = ref('1');
const monthDay = ref('1');
const yearDate = ref('01-01');
const interval = ref('15');
const customRules = ref(['0 9,18 * * 1-5', '0 12 * * 0']);

const weekdays = [['1','Понедельник'],['2','Вторник'],['3','Среда'],['4','Четверг'],['5','Пятница'],['6','Суббота'],['0','Воскресенье']];
const fields = ['Минуты','Часы','День месяца','Месяц','День недели'];
const ranges = ['0–59','0–23','1–31','1–12','0–7'];

const parts = computed(() => {
    const p = time.value.split(':').map(Number);
    return { hour: Number.isFinite(p[0]) ? p[0] : 0, minute: Number.isFinite(p[1]) ? p[1] : 0 };
});

const generatedCron = computed(() => {
    const m = parts.value.minute, h = parts.value.hour;
    if (preset.value === 'daily') return m + ' ' + h + ' * * *';
    if (preset.value === 'weekly') return m + ' ' + h + ' * * ' + weekday.value;
    if (preset.value === 'monthly') return m + ' ' + h + ' ' + monthDay.value + ' * *';
    if (preset.value === 'yearly') {
        const p = yearDate.value.split('-');
        return m + ' ' + h + ' ' + Number(p[2]) + ' ' + Number(p[1]) + ' *';
    }
    if (preset.value === 'weekdays') return m + ' ' + h + ' * * 1-5';
    if (preset.value === 'weekends') return m + ' ' + h + ' * * 0,6';
    if (preset.value === 'interval') return '*/' + Math.max(1, Number(interval.value) || 1) + ' * * * *';
    return '0 * * * *';
});

const builderDescription = computed(() => {
    const t = String(parts.value.hour).padStart(2,'0') + ':' + String(parts.value.minute).padStart(2,'0');
    if (preset.value === 'daily') return 'Каждый день в ' + t;
    if (preset.value === 'weekly') return 'Каждую неделю, ' + (weekdays.find(x => x[0] === weekday.value)?.[1] || 'выбранный день') + ' в ' + t;
    if (preset.value === 'monthly') return 'Каждый месяц, ' + monthDay.value + '-го числа в ' + t;
    if (preset.value === 'yearly') return 'Каждый год, ' + yearDate.value.split('-').reverse().join('.') + ' в ' + t;
    if (preset.value === 'weekdays') return 'По будням в ' + t;
    if (preset.value === 'weekends') return 'По выходным в ' + t;
    if (preset.value === 'interval') return 'Каждые ' + interval.value + ' минут';
    return 'Каждый час';
});

function parseField(raw, min, max) {
    const values = new Set();
    const errors = [];
    raw.split(',').forEach(chunk => {
        const item = chunk.trim();
        if (!item) { errors.push('пустой элемент'); return; }
        const pieces = item.split('/');
        const base = pieces[0];
        const step = pieces.length === 2 ? Number(pieces[1]) : 1;
        if (!Number.isInteger(step) || step < 1) { errors.push('шаг должен быть целым числом больше 0'); return; }
        let start = min, end = max;
        if (base !== '*') {
            if (base.includes('-')) {
                const p = base.split('-').map(Number);
                if (!Number.isInteger(p[0]) || !Number.isInteger(p[1])) { errors.push('диапазон некорректен'); return; }
                start = p[0]; end = p[1];
            } else {
                const n = Number(base);
                if (!Number.isInteger(n)) { errors.push('значение должно быть числом'); return; }
                start = n; end = pieces.length === 2 ? max : n;
            }
        }
        if (start < min || end > max || start > end) { errors.push('значение выходит за допустимый диапазон'); return; }
        for (let n = start; n <= end; n += step) values.add(n);
    });
    return { values, errors };
}

function parseCron(expression) {
    const raw = expression.trim().split(/\\s+/);
    if (raw.length !== 5) return { valid:false, error:'Cron должен содержать 5 полей: минуты, часы, день месяца, месяц, день недели.', field:null, fields:raw };
    const mins = [0,0,1,1,0], maxs = [59,23,31,12,7];
    const parsed = raw.map((v,i) => parseField(v, mins[i], maxs[i]));
    const bad = parsed.findIndex(x => x.errors.length);
    return bad === -1 ? {valid:true,error:'',field:null,fields:raw,parsed} : {valid:false,error:parsed[bad].errors[0],field:bad,fields:raw,parsed};
}

function describeCron(expression) {
    const state = parseCron(expression);
    if (!state.valid) return '';
    const f = state.fields;
    const timeText = f[1] === '*' ? 'в любое время' : 'в ' + String(Number(f[1])).padStart(2,'0') + ':' + (f[0] === '*' ? '00' : String(Number(f[0])).padStart(2,'0'));
    if (f[0].startsWith('*/') && f[1] === '*') return 'Каждые ' + f[0].slice(2) + ' минут.';
    if (f[2] === '*' && f[3] === '*' && f[4] === '*') return 'Каждый день ' + timeText + '.';
    if (f[2] === '*' && f[3] === '*' && f[4] === '1-5') return 'По будням ' + timeText + '.';
    if (f[2] === '*' && f[3] === '*' && f[4] === '0,6') return 'По выходным ' + timeText + '.';
    if (f[2] === '*' && f[3] === '*' && f[4] !== '*') return 'В дни недели ' + f[4] + ', ' + timeText + '.';
    if (f[2] !== '*' && f[3] === '*') return 'Каждый месяц ' + f[2] + '-го числа, ' + timeText + '.';
    if (f[2] !== '*' && f[3] !== '*') return 'Каждый год: ' + f[2] + '.' + f[3] + ', ' + timeText + '.';
    return 'Минуты ' + f[0] + ', часы ' + f[1] + ', день месяца ' + f[2] + ', месяц ' + f[3] + ', день недели ' + f[4] + '.';
}

function nextRuns(expression, count) {
    const state = parseCron(expression);
    if (!state.valid) return [];
    const result = [], cursor = new Date();
    cursor.setSeconds(0,0); cursor.setMinutes(cursor.getMinutes()+1);
    for (let i=0; i<366*24*60 && result.length<count; i++) {
        const values = [cursor.getMinutes(),cursor.getHours(),cursor.getDate(),cursor.getMonth()+1,cursor.getDay()];
        if (state.parsed.every((x,j) => x.values.has(values[j]))) result.push(new Date(cursor));
        cursor.setMinutes(cursor.getMinutes()+1);
    }
    return result;
}

const builderRuns = computed(() => nextRuns(generatedCron.value, 5));
const rules = computed(() => customRules.value.map((expression,index) => ({ expression,index,state:parseCron(expression),description:describeCron(expression),runs:nextRuns(expression,3) })));
const allRuns = computed(() => rules.value.flatMap(r => r.runs.map(date => ({date,expression:r.expression}))).sort((a,b)=>a.date-b.date).slice(0,8));
const formatRun = date => new Intl.DateTimeFormat('ru-RU',{day:'2-digit',month:'2-digit',year:'numeric',hour:'2-digit',minute:'2-digit'}).format(date);
const addRule = () => customRules.value.push('0 12 * * 1-5');
const removeRule = index => { if (customRules.value.length > 1) customRules.value.splice(index,1); };
const useExample = () => { customRules.value=['0 9,18 * * 1-5','0 12 * * 0']; };
const fixRule = index => {
    const rule = rules.value[index];
    const copy = rule.expression.trim().split(/\\s+/);
    if (copy.length === 5) copy[rule.state.field ?? 0] = ['0','0','1','1','0'][rule.state.field ?? 0];
    customRules.value[index] = copy.join(' ');
};
</script>

<template>
    <Head title="Конструктор расписаний" />
    <AppLayout>
        <section class="page cron-page">
            <PageHeader eyebrow="09 / SCHEDULE" title="Конструктор расписаний" description="Создавай cron-расписания без знания синтаксиса или переходи в расширенный режим для сложных правил." />

            <div class="cron-tabs">
                <button type="button" class="cron-tab" :class="{ 'is-active': mode === 'builder' }" @click="mode='builder'">Конструктор</button>
                <button type="button" class="cron-tab" :class="{ 'is-active': mode === 'cron' }" @click="mode='cron'">Cron</button>
            </div>

            <div v-if="mode === 'builder'" class="cron-panel">
                <div class="cron-builder">
                    <label class="cron-field"><span>Тип расписания</span><select v-model="preset">
                        <option value="daily">Каждый день</option><option value="weekdays">По будням</option><option value="weekends">По выходным</option><option value="weekly">Каждую неделю</option><option value="monthly">Каждый месяц</option><option value="yearly">Каждый год</option><option value="interval">Каждые N минут</option><option value="hourly">Каждый час</option>
                    </select></label>
                    <label v-if="!['interval','hourly'].includes(preset)" class="cron-field"><span>Время</span><input v-model="time" type="time"></label>
                    <label v-if="preset === 'weekly'" class="cron-field"><span>День недели</span><select v-model="weekday"><option v-for="[id,label] in weekdays" :key="id" :value="id">{{ label }}</option></select></label>
                    <label v-if="preset === 'monthly'" class="cron-field"><span>Число месяца</span><input v-model.number="monthDay" type="number" min="1" max="31"></label>
                    <label v-if="preset === 'yearly'" class="cron-field"><span>Дата</span><input v-model="yearDate" type="date"></label>
                    <label v-if="preset === 'interval'" class="cron-field"><span>Интервал, минут</span><select v-model="interval"><option v-for="value in [1,5,10,15,20,30]" :key="value" :value="String(value)">{{ value }}</option></select></label>
                </div>
                <div class="cron-result">
                    <div><span class="cron-label">Cron-выражение</span><code>{{ generatedCron }}</code></div>
                    <div><span class="cron-label">Описание</span><strong>{{ builderDescription }}</strong></div>
                </div>
                <div class="cron-runs"><div class="cron-section-title">Ближайшие запуски</div><div class="cron-run-list"><span v-for="run in builderRuns" :key="run.toISOString()">{{ formatRun(run) }}</span></div></div>
            </div>

            <div v-else class="cron-panel">
                <div class="cron-example"><div><strong>Сложное расписание</strong><span>В 09:00 и 18:00 по будням, а в воскресенье — только в 12:00.</span></div><button type="button" class="cron-secondary" @click="useExample">Подставить пример</button></div>
                <div class="cron-rules">
                    <div v-for="rule in rules" :key="rule.index" class="cron-rule">
                        <div class="cron-rule__head"><span>Правило {{ rule.index + 1 }}</span><button v-if="customRules.length > 1" type="button" class="cron-remove" @click="removeRule(rule.index)">Удалить</button></div>
                        <input v-model="customRules[rule.index]" class="cron-input" :class="{ 'is-invalid': !rule.state.valid }" spellcheck="false" autocomplete="off">
                        <div v-if="!rule.state.valid" class="cron-error">
                            <strong>{{ rule.state.field === null ? 'Ошибка выражения' : 'Ошибка в поле «' + fields[rule.state.field] + '»' }}</strong>
                            <span>{{ rule.state.error }}</span><span v-if="rule.state.field !== null">Допустимый диапазон: {{ ranges[rule.state.field] }}</span>
                            <button type="button" class="cron-fix" @click="fixRule(rule.index)">Предложить исправление</button>
                        </div>
                        <div v-else class="cron-valid">✓ Выражение корректно</div>
                        <div v-if="rule.state.valid" class="cron-rule__description">{{ rule.description }}</div>
                    </div>
                </div>
                <button type="button" class="cron-add" @click="addRule">+ Добавить cron-правило</button>
                <div class="cron-result">
                    <div><span class="cron-label">Выражения</span><div class="cron-code-list"><code v-for="rule in customRules" :key="rule">{{ rule }}</code></div></div>
                    <div><span class="cron-label">Ближайшие запуски</span><div v-if="allRuns.length" class="cron-run-list"><span v-for="run in allRuns" :key="run.date.toISOString()+run.expression">{{ formatRun(run.date) }} · {{ run.expression }}</span></div><span v-else class="cron-empty">Исправь выражения, чтобы увидеть ближайшие запуски.</span></div>
                </div>
                <div class="cron-reference"><span class="cron-label">Поля cron</span><div class="cron-reference__grid"><span><b>Минуты</b> 0–59</span><span><b>Часы</b> 0–23</span><span><b>День месяца</b> 1–31</span><span><b>Месяц</b> 1–12</span><span><b>День недели</b> 0–7</span></div></div>
            </div>
            <p class="cron-note">Ближайшие запуски рассчитываются по локальному часовому поясу браузера. В расширенном режиме можно задать несколько независимых cron-правил.</p>
        </section>
    </AppLayout>
</template>
