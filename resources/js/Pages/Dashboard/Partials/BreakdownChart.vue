<script setup>
import { onMounted, ref } from 'vue';
import { Chart } from 'chart.js/auto';

const props = defineProps({
    breakdownData: {
        type: Object,
        required: true,
    },
    title: {
        type: String,
        required: true
    }
});

const chartCanvas = ref(null);

const formatCurrency = (amount) => {
    const value = amount || 0;
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(value);
};

onMounted(() => {
    if (chartCanvas.value) {
        const ctx = chartCanvas.value.getContext('2d');
        const labels = Object.keys(props.breakdownData || {});
        const data = Object.values(props.breakdownData || {});
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Subscription Cost',
                    data: data,
                    borderColor: 'rgba(139, 92, 246, 1)',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgba(139, 92, 246, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: value => formatCurrency(value)
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: context => formatCurrency(context.raw)
                        }
                    }
                }
            }
        });
    }
});
</script>

<template>
    <div class="rounded-2xl bg-white p-6 shadow-lg">
        <h3 class="mb-6 text-lg font-semibold text-gray-900">{{ title }}</h3>
        <div class="relative h-[300px]">
            <canvas ref="chartCanvas"></canvas>
        </div>
    </div>
</template>