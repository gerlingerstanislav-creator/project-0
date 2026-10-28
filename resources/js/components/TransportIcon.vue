<script setup>
defineProps({
  name: { type: String, required: true },
});
</script>

<template>
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    <template v-if="name === 'clock'"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></template>
    <template v-else-if="name === 'shield'"><path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11Z"/><path d="m9 12 2 2 4-4"/></template>
    <template v-else-if="name === 'armchair'"><path d="M7 12V8a5 5 0 0 1 10 0v4"/><path d="M4 11a2 2 0 0 0-2 2v3a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-3a2 2 0 0 0-4 0v2H6v-2a2 2 0 0 0-2-2Z"/><path d="M6 19v2m12-2v2"/></template>
    <template v-else-if="name === 'heart-hand'"><path d="M12 20s-8-5.6-8-11a4.5 4.5 0 0 1 8-2 4.5 4.5 0 0 1 8 2c0 5.4-8 11-8 11Z"/><path d="M8.5 12.5 11 15l4.5-5"/></template>
    <template v-else-if="name === 'hospital'"><rect x="4" y="4" width="16" height="17" rx="2"/><path d="M10 8h4m-2-2v4M9 21v-5h6v5M7 12h2m6 0h2"/></template>
    <template v-else-if="name === 'stethoscope'"><path d="M6 3v5a5 5 0 0 0 10 0V3M4 3h4m6 0h4M11 13v3a5 5 0 0 0 10 0v-2"/><circle cx="21" cy="12" r="2"/></template>
    <template v-else-if="name === 'file-check'"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><path d="M14 2v6h6M8 13h4m-4 4 2 2 5-5"/></template>
    <template v-else-if="name === 'activity'"><path d="M3 12h4l3-7 4 14 3-7h4"/></template>
    <template v-else-if="name === 'landmark'"><path d="m3 10 9-7 9 7M4 10h16M6 10v9m4-9v9m4-9v9m4-9v9M3 21h18"/></template>
    <template v-else-if="name === 'map-pin'"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></template>
  </svg>
</template>
