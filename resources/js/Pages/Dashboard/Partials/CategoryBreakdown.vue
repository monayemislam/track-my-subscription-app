<script setup>
import { onMounted, ref } from 'vue';
import { Chart } from 'chart.js/auto';

const props = defineProps({
    categoryBreakdown: {
        type: Object,
        required: true,
    },
});

const chartCanvas = ref(null);

onMounted(() => {
    const ctx = chartCanvas.value.getContext('2d');
    
    const labels = Object.keys(props.categoryBreakdown);
    const data = Object.values(props.categoryBreakdown);
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF',
                    '#FF9F40',
                    '#7CBA3B',
                ],
            }],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                },
                title: {
                    display: true,
                    text: 'Spending by Category',
                },
            },
        },
    });
});
</script>

<template>
    <div class="rounded-lg bg-white p-6 shadow-sm">
        <canvas ref="chartCanvas" height="200"></canvas>
    </div>
</template>
