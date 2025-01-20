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

const subscriptionTypes = [
    {
        name: 'Weekly',
        icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        bgColor: 'bg-emerald-100',
        textColor: 'text-emerald-600',
        dotColor: 'bg-emerald-500'
    },
    {
        name: 'Monthly',
        icon: 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        bgColor: 'bg-amber-100',
        textColor: 'text-amber-600',
        dotColor: 'bg-amber-500'
    },
    {
        name: 'Quarterly',
        icon: 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z',
        bgColor: 'bg-blue-100',
        textColor: 'text-blue-600',
        dotColor: 'bg-blue-500'
    },
    {
        name: 'Yearly',
        icon: 'M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z',
        bgColor: 'bg-rose-100',
        textColor: 'text-rose-600',
        dotColor: 'bg-rose-500'
    }
];
</script>

<template>
    <div class="rounded-2xl bg-white p-6">
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
                <div v-for="type in subscriptionTypes" :key="type.name" 
                     class="flex items-center justify-between py-2">
                    <div class="flex items-center space-x-3">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full" :class="type.bgColor">
                            <svg class="h-4 w-4" :class="type.textColor" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="type.icon" />
                            </svg>
                        </span>
                        <span class="text-sm font-medium text-gray-600">{{ type.name }}</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-900">
                        {{ formatCurrency(stats?.[`${type.name.toLowerCase()}Cost`] || 0) }}
                    </span>
                </div>
            </div>

            <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-4">
                <span class="text-sm font-medium text-gray-600">Total Subscriptions</span>
                <span class="text-lg font-semibold text-gray-900">{{ stats?.totalSubscriptions || 0 }}</span>
            </div>
        </div>
    </div>
</template>
