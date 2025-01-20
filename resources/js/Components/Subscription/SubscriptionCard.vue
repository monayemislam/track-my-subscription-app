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

const emit = defineEmits(['edit']);

const handleEdit = () => {
    console.log('Edit button clicked'); // Debug log
    emit('edit');
};

const getDaysUntilRenewal = () => {
    const renewalDate = new Date(props.subscription.renewal_date);
    const today = new Date();
    const diffTime = Math.abs(renewalDate - today);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    return diffDays;
};
</script>

<template>
    <div 
        class="bg-white rounded-2xl shadow-sm hover:shadow transition-all duration-300 relative overflow-hidden"
        :style="{
            borderLeft: `2px solid ${subscription.category.color}`
        }"
    >
        <!-- Color accent corner -->
        <div 
            :style="{ backgroundColor: subscription.category.color }"
            class="absolute top-0 right-0 w-[200px] h-[200px] rounded-bl-[100%] opacity-[0.08] z-[2]"
        ></div>

        <!-- Main Content -->
        <div class="p-4 relative z-[3]">
            <!-- Header -->
            <div class="flex justify-between items-start">
                <div class="flex items-center gap-2">
                    <div 
                        :style="{ backgroundColor: subscription.category.color }"
                        class="w-10 h-10 rounded-full flex items-center justify-center"
                    >
                        <span class="text-white font-medium text-base uppercase">
                            {{ subscription.name.charAt(0) }}
                        </span>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">{{ subscription.name }}</h3>
                        <p class="text-xs text-gray-500">{{ subscription.category.name }}</p>
                    </div>
                </div>
                <div 
                    :style="{ 
                        backgroundColor: `${subscription.category.color}15`,
                        color: subscription.category.color 
                    }"
                    class="px-2.5 py-1 rounded-full"
                >
                    <span class="text-xs">Due in {{ getDaysUntilRenewal() }} days</span>
                </div>
            </div>

            <!-- Info Grid -->
            <div class="grid grid-cols-3 gap-3 mt-4">
                <div class="p-2">
                    <p class="text-xs text-gray-500 mb-0.5 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Cost
                    </p>
                    <p class="text-sm font-semibold text-gray-900">{{ formatCurrency(subscription.cost) }}</p>
                </div>
                <div class="p-2">
                    <p class="text-xs text-gray-500 mb-0.5 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Billing
                    </p>
                    <p class="text-sm font-semibold capitalize text-gray-900">{{ subscription.frequency }}</p>
                </div>
                <div class="p-2">
                    <p class="text-xs text-gray-500 mb-0.5 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Status
                    </p>
                    <p class="text-sm font-semibold text-green-600">Active</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-between items-center mt-4">
                <div class="flex gap-2">
                    <button
                        @click="handleEdit"
                        class="inline-flex items-center px-2.5 py-1 text-xs text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg"
                    >
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </button>
                    <button
                        @click="showDeleteModal = true"
                        class="inline-flex items-center px-2.5 py-1 text-xs text-red-600 bg-red-50 hover:bg-red-100 rounded-lg"
                    >
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </div>

                <a
                    v-if="subscription.website_url"
                    :href="subscription.website_url"
                    target="_blank"
                    :style="{ 
                        backgroundColor: `${subscription.category.color}15`,
                        color: subscription.category.color 
                    }"
                    class="inline-flex items-center px-2.5 py-1 text-xs font-medium hover:opacity-80 rounded-lg"
                >
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002-2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Visit
                </a>
            </div>
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
