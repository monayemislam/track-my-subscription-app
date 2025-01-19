<script setup>
import { Link } from '@inertiajs/vue3';
import RenewalBadge from './RenewalBadge.vue';

const props = defineProps({
    subscription: {
        type: Object,
        required: true
    }
});

defineEmits(['edit']);

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
};
</script>

<template>
    <div class="bg-white rounded-lg border shadow-sm p-6">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-lg font-medium text-gray-900">
                    {{ subscription.name }}
                </h3>
                <div class="mt-1 flex items-center space-x-2 text-sm text-gray-500">
                    <span 
                        class="inline-block w-3 h-3 rounded-full"
                        :style="{ backgroundColor: subscription.category.color }"
                    ></span>
                    <span>{{ subscription.category.name }}</span>
                    <span>•</span>
                    <span>{{ subscription.frequency }}</span>
                    <span>•</span>
                    <span>{{ formatCurrency(subscription.cost) }}</span>
                </div>
            </div>
            
            <RenewalBadge :date="subscription.renewal_date" />
        </div>

        <div class="mt-4 flex justify-between items-center">
            <div class="flex space-x-4">
                <button
                    @click="$emit('edit')"
                    class="text-sm text-gray-600 hover:text-gray-900"
                >
                    Edit
                </button>
                <Link
                    :href="route('subscriptions.destroy', subscription.id)"
                    method="delete"
                    as="button"
                    class="text-sm text-red-600 hover:text-red-900"
                >
                    Delete
                </Link>
            </div>

            <a
                v-if="subscription.website_url"
                :href="subscription.website_url"
                target="_blank"
                class="text-sm text-indigo-600 hover:text-indigo-900"
            >
                Visit Website
            </a>
        </div>
    </div>
</template>
