<script setup>
import { computed } from 'vue';

const props = defineProps({
    date: {
        type: String,
        required: true
    }
});

const daysUntilRenewal = computed(() => {
    const today = new Date();
    const renewalDate = new Date(props.date);
    const diffTime = renewalDate - today;
    return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
});

const badgeColor = computed(() => {
    if (daysUntilRenewal.value <= 3) return 'bg-red-100 text-red-800';
    if (daysUntilRenewal.value <= 7) return 'bg-yellow-100 text-yellow-800';
    return 'bg-green-100 text-green-800';
});
</script>

<template>
    <div :class="['rounded-full px-3 py-1 text-sm', badgeColor]">
        <span v-if="daysUntilRenewal <= 0">
            Due today
        </span>
        <span v-else-if="daysUntilRenewal === 1">
            Due tomorrow
        </span>
        <span v-else>
            Due in {{ daysUntilRenewal }} days
        </span>
    </div>
</template>
