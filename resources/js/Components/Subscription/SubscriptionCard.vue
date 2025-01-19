<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import RenewalBadge from './RenewalBadge.vue';
import { useToast } from '@/Composables/useToast';
import ConfirmationModal from '@/Components/UI/ConfirmationModal.vue';
import EditSubscriptionModal from '@/Pages/Subscriptions/Partials/EditSubscriptionModal.vue';

const props = defineProps({
    subscription: {
        type: Object,
        required: true
    },
    categories: {
        type: Array,
        required: true
    }
});

const showDeleteModal = ref(false);
const showEditModal = ref(false);
const { showToast } = useToast();

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
};

const handleDelete = () => {
    router.delete(route('subscriptions.destroy', props.subscription.id), {
        preserveScroll: true,
        onSuccess: () => {
            showToast('Subscription deleted successfully');
            showDeleteModal.value = false;
        },
        onError: (error) => {
            showToast(error.message || 'Failed to delete subscription', 'error');
            showDeleteModal.value = false;
        },
    });
};
</script>

<template>
    <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 p-6 border border-gray-100">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-xl font-semibold text-gray-900">
                    {{ subscription.name }}
                </h3>
                <div class="mt-2 flex items-center space-x-2 text-sm text-gray-600">
                    <span 
                        class="inline-block w-3 h-3 rounded-full"
                        :style="{ backgroundColor: subscription.category.color }"
                    ></span>
                    <span>{{ subscription.category.name }}</span>
                    <span class="text-gray-400">•</span>
                    <span>{{ subscription.frequency }}</span>
                    <span class="text-gray-400">•</span>
                    <span class="font-medium">{{ formatCurrency(subscription.cost) }}</span>
                </div>
            </div>
            
            <RenewalBadge :date="subscription.renewal_date" />
        </div>

        <div class="mt-6 flex justify-between items-center">
            <div class="flex space-x-4">
                <button
                    @click="showEditModal = true"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors duration-200"
                >
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </button>
                <button
                    @click="showDeleteModal = true"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 rounded-md transition-colors duration-200"
                >
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete
                </button>
            </div>

            <a
                v-if="subscription.website_url"
                :href="subscription.website_url"
                target="_blank"
                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 rounded-md transition-colors duration-200"
            >
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                Visit Website
            </a>
        </div>

        <!-- Delete Confirmation Modal -->
        <ConfirmationModal
            :show="showDeleteModal"
            title="Delete Subscription"
            message="Are you sure you want to delete this subscription? This action cannot be undone."
            @confirm="handleDelete"
            @cancel="showDeleteModal = false"
        />

        <!-- Edit Modal -->
        <EditSubscriptionModal
            v-if="showEditModal"
            :show="showEditModal"
            :subscription="subscription"
            :categories="categories"
            @close="showEditModal = false"
        />
    </div>
</template>
