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
    <div class="rounded-lg bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between border-b pb-4">
            <h3 class="text-lg font-medium text-gray-900">
                Upcoming Renewals
            </h3>
            <Link
                :href="route('subscriptions.index')"
                class="text-sm text-indigo-600 hover:text-indigo-900"
            >
                View all subscriptions
            </Link>
        </div>

        <div v-if="upcomingRenewals.length === 0" class="py-6 text-center text-gray-500">
            No upcoming renewals in the next few days.
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
