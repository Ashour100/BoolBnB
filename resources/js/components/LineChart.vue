<template>
    <div>
        <LineChartGenerator :chart-options="chartOptions" :chart-data="chartData" :chart-id="chartId"
            :dataset-id-key="datasetIdKey" :plugins="plugins" :css-classes="cssClasses" :styles="styles" :width="width"
            :height="height" />
    </div>
</template>

<script>
import { Line as LineChartGenerator } from 'vue-chartjs/legacy'

import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    CategoryScale,
    PointElement
} from 'chart.js'

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    CategoryScale,
    PointElement
)

export default {
    name: 'LineChart',
    components: {
        LineChartGenerator
    },
    props: {
        chartId: {
            type: String,
            default: 'line-chart'
        },
        datasetIdKey: {
            type: String,
            default: 'label'
        },
        width: {
            type: Number,
            default: 400
        },
        height: {
            type: Number,
            default: 300
        },
        color:{
            type: String,
            default: 'red'
        },
        cssClasses: {
            default: '',
            type: String
        },
        styles: {
            type: Object,
            default: () => { }
        },
        plugins: {
            type: Array,
            default: () => []
        },
        data: {
        type: Array,
        default: () => [40, 39, 10, 40, 39, 80, 40]
        },
        labelMonth: {
        type: Array,
        default: () => []
        },
        },
        data() {
            return {
                chartData: {
                    labels: this.labelMonth,
                    datasets: [
                        {
                            label: this.datasetIdKey,
                            backgroundColor: this.color,
                            borderColor: 'darkgray',
                            data: this.data
                        }
                    ]
                },
                chartOptions: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            }
        }
    }
</script>
