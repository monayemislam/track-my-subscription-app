<script setup>
import { onMounted, ref } from 'vue';
import { Chart } from 'chart.js/auto';

const props = defineProps({
    categoryBreakdown: {
        type: Object,
        required: true,
    }
});

const chartCanvas = ref(null);

onMounted(() => {
    const ctx = chartCanvas.value.getContext('2d');
    
    const labels = Object.keys(props.categoryBreakdown);
    const data = Object.values(props.categoryBreakdown);
    
    new Chart(ctx, {
        type: 'polarArea',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: [
                    'rgba(139, 92, 246, 0.7)',  // violet - Development Tools
                    'rgba(59, 130, 246, 0.7)',  // blue - Recipe
                    'rgba(16, 185, 129, 0.7)',  // emerald - Writing Tools
                    'rgba(245, 158, 11, 0.7)',  // amber - Design Tools
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    pointLabels: {
                        display: true,
                        centerPointLabels: true,
                        font: {
                            size: 12
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            family: "'Inter', sans-serif",
                            size: 12
                        }
                    }
                }
            }
        }
    });
});
</script>

<template>
    <div class="rounded-2xl bg-white p-6 shadow-lg">
        <h3 class="mb-6 text-lg font-semibold text-gray-900">Category Breakdown</h3>
        <div class="relative h-[300px]">
            <canvas ref="chartCanvas"></canvas>
        </div>
    </div>
</template>
