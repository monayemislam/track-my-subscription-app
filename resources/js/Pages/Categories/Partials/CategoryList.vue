<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    categories: Array
});

const deleteCategory = (id) => {
    if (confirm('Are you sure you want to delete this category?')) {
        router.delete(route('categories.destroy', id));
    }
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
                                @click="deleteCategory(category.id)"
                                class="text-red-600 hover:text-red-900"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template> 