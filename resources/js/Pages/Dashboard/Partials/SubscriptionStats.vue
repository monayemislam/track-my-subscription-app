<script setup>
defineProps({
    stats: {
        type: Object,
        required: true,
    },
});

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
};
</script>

<template>
    <div class="flex gap-4">
        <div class="flex-1 rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-600">Total Subscriptions</h3>
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <p class="mt-4 text-2xl font-semibold text-gray-900">
                {{ stats.totalSubscriptions }}
            </p>
        </div>

        <div class="flex-1 rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-600">Monthly Cost</h3>
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="mt-4 text-2xl font-semibold text-gray-900">
                {{ formatCurrency(stats.monthlyCost) }}
            </p>
        </div>

        <div class="flex-1 rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-600">Yearly Cost</h3>
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </div>
            <p class="mt-4 text-2xl font-semibold text-gray-900">
                {{ formatCurrency(stats.yearlyCost) }}
            </p>
        </div>
    </div>
</template>
