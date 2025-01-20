<script setup>
import { Link } from '@inertiajs/vue3';
import RenewalBadge from '@/Components/Subscription/RenewalBadge.vue';

defineProps({
    upcomingRenewals: {
        type: Array,
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
    <div class="rounded-2xl bg-white p-6 shadow-lg">
        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
            <h3 class="text-lg font-semibold text-gray-900">
                Upcoming Renewals
            </h3>
            <Link
                :href="route('subscriptions.index')"
                class="inline-flex items-center text-sm font-medium text-violet-600 hover:text-violet-700"
            >
                View all
                <svg class="ml-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </Link>
        </div>

        <div v-if="upcomingRenewals.length === 0" class="flex items-center justify-center py-12">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="mt-4 text-gray-500">No upcoming renewals</p>
            </div>
        </div>

        <ul v-else role="list" class="divide-y divide-gray-200">
            <li
                v-for="subscription in upcomingRenewals"
                :key="subscription.id"
                class="flex items-center justify-between py-4"
            >
                <div>
                    <p class="font-medium text-gray-900">
                        {{ subscription.name }}
                    </p>
                    <div class="mt-1 flex items-center space-x-2 text-sm text-gray-500">
                        <span 
                            class="inline-block h-2 w-2 rounded-full"
                            :style="{ backgroundColor: subscription.category.color }"
                        ></span>
                        <span>{{ subscription.category.name }}</span>
                        <span>•</span>
                        <span>{{ formatCurrency(subscription.cost) }}</span>
                    </div>
                </div>

                <RenewalBadge :date="subscription.renewal_date" />
            </li>
        </ul>
    </div>
</template>
