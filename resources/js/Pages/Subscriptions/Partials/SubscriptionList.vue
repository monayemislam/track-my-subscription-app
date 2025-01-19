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
const { showToast } = useToast();
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
                @edit="editingSubscription = subscription"
            />
        </div>

        <Pagination 
            :links="subscriptions.links" 
            class="mt-6" 
        />

        <EditSubscriptionModal
            v-if="editingSubscription"
            :subscription="editingSubscription"
            :categories="categories"
            @close="editingSubscription = null"
        />
    </div>
</template>
