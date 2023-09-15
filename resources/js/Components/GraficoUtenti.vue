<template>
    <Bar
        id="my-chart-id"
        :options="chartOptions"
        :data="chartData"
    />
</template>

<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
    name: 'BarChartUtenti',
    components: { Bar },
    props:['countOfUsersGroupByMonths'],
    data() {
        return {
            chartData: {
                labels:  this.countOfUsersGroupByMonths ? this.countOfUsersGroupByMonths.map((obj) => obj.month.toString()) : null ,
                datasets: [
                    {
                        label: 'New Users ' + this.countOfUsersGroupByMonths[0].year,
                        data: this.countOfUsersGroupByMonths ? this.countOfUsersGroupByMonths.map((obj) => obj.data) : null,
                        backgroundColor: [
                            'rgba(9,199,53,0.93)',
                        ],
                    }
                ]
            },
            chartOptions: {
                responsive: true,
                scales: {
                    y: {
                        ticks: {
                            stepSize:1
                        }
                    }
                }
            }
        }
    }
}
</script>
