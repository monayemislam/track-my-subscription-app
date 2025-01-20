<script setup>
defineProps({
    stats: {
        type: Object,
        required: true,
    },
});

const formatCurrency = (amount) => {
    const value = amount || 0;
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(value);
};
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Subscription Costs</h3>
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-violet-100">
                <svg class="h-4 w-4 text-violet-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </span>
        </div>

        <div class="space-y-3">
            <div v-for="(type, index) in ['Weekly', 'Monthly', 'Quarterly', 'Yearly']" :key="index" 
                 class="flex items-center justify-between py-2">
                <div class="flex items-center space-x-3">
                    <span :class="`inline-block h-2 w-2 rounded-full bg-${['emerald', 'amber', 'blue', 'rose'][index]}-500`"></span>
                    <span class="text-sm font-medium text-gray-600">{{ type }}</span>
                </div>
                <span class="text-sm font-semibold text-gray-900">
                    {{ formatCurrency(stats[`${type.toLowerCase()}Cost`]) }}
                </span>
            </div>
        </div>

        <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-4">
            <span class="text-sm font-medium text-gray-600">Total Subscriptions</span>
            <span class="text-lg font-semibold text-gray-900">{{ stats.totalSubscriptions }}</span>
        </div>
    </div>
</template>
