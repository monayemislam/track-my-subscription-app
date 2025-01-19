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
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
        <div class="rounded-lg bg-white p-6 shadow-sm">
            <h3 class="text-sm font-medium text-gray-500">Total Subscriptions</h3>
            <p class="mt-2 text-3xl font-semibold text-gray-900">
                {{ stats.totalSubscriptions }}
            </p>
        </div>

        <div class="rounded-lg bg-white p-6 shadow-sm">
            <h3 class="text-sm font-medium text-gray-500">Monthly Cost</h3>
            <p class="mt-2 text-3xl font-semibold text-gray-900">
                {{ formatCurrency(stats.monthlyCost) }}
            </p>
        </div>

        <div class="rounded-lg bg-white p-6 shadow-sm">
            <h3 class="text-sm font-medium text-gray-500">Yearly Cost</h3>
            <p class="mt-2 text-3xl font-semibold text-gray-900">
                {{ formatCurrency(stats.yearlyCost) }}
            </p>
        </div>
    </div>
</template>
