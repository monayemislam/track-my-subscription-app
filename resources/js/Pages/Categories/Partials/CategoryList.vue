<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { useToast } from '@/Composables/useToast';
import ConfirmationModal from '@/Components/UI/ConfirmationModal.vue';

const props = defineProps({
    categories: Array
});

const { showToast } = useToast();
const showDeleteModal = ref(false);
const categoryToDelete = ref(null);

const confirmDelete = (category) => {
    // First check if category has subscriptions
    if (category.subscriptions_count > 0) {
        showToast("Cannot delete category that has subscriptions. Please delete the subscriptions first.", 'error');
        return;
    }

    // If no subscriptions, show delete confirmation modal
    categoryToDelete.value = category;
    showDeleteModal.value = true;
};

const handleDelete = () => {
    router.delete(route('categories.destroy', categoryToDelete.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            showToast('Category deleted successfully');
            showDeleteModal.value = false;
        },
        onError: () => {
            showToast('Failed to delete category', 'error');
            showDeleteModal.value = false;
        },
    });
};
</script>

<template>
    <div class="space-y-4">
        <div v-if="categories.length === 0" class="text-center py-12">
            <p class="text-gray-500">No categories found.</p>
        </div>
        
        <div v-else class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Color</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="category in categories" :key="category.id">
                        <td class="px-6 py-4 whitespace-nowrap">{{ category.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div 
                                    class="w-6 h-6 rounded-full mr-2"
                                    :style="{ backgroundColor: category.color }"
                                ></div>
                                {{ category.color }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button
                                @click="confirmDelete(category)"
                                class="text-red-600 hover:text-red-900"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <ConfirmationModal
            :show="showDeleteModal"
            title="Delete Category"
            message="Are you sure you want to delete this category? This action cannot be undone."
            @confirm="handleDelete"
            @cancel="showDeleteModal = false"
        />
    </div>
</template> 