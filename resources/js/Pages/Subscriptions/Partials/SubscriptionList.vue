<script setup>
import { ref } from 'vue';
import SubscriptionCard from '@/Components/Subscription/SubscriptionCard.vue';
import EditSubscriptionModal from './EditSubscriptionModal.vue';
import Pagination from '@/Components/Pagination.vue';
import { useToast } from '@/Composables/useToast';

const props = defineProps({
    subscriptions: Object, // Paginated data
    categories: Array,
});

const editingSubscription = ref(null);
const showEditModal = ref(false);
const { showToast } = useToast();

const handleEdit = (subscription) => {
    console.log('Edit clicked:', subscription); // Debug log
    editingSubscription.value = subscription;
    showEditModal.value = true;
};
</script>

<template>
    <div>
        <div v-if="subscriptions.data.length === 0" class="text-center py-12">
            <p class="text-gray-500">No subscriptions found.</p>
        </div>

        <div v-else class="space-y-4">
            <SubscriptionCard
                v-for="subscription in subscriptions.data"
                :key="subscription.id"
                :subscription="subscription"
                :categories="categories"
                @edit="handleEdit(subscription)"
            />
        </div>

        <Pagination 
            :links="subscriptions.links" 
            class="mt-6" 
        />

        <EditSubscriptionModal
            v-if="editingSubscription"
            :show="showEditModal"
            :subscription="editingSubscription"
            :categories="categories"
            @close="() => {
                showEditModal = false;
                editingSubscription = null;
            }"
        />
    </div>
</template>
