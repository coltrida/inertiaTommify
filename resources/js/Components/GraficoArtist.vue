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
    name: 'BarChartArtist',
    components: { Bar },
    props:['countOfArtistGroupByMonths'],
    data() {
        return {
            chartData: {
                labels:  this.countOfArtistGroupByMonths ? this.countOfArtistGroupByMonths.map((obj) => obj.month.toString()) : null ,
                datasets: [
                    {
                        label: 'New Artists ' + this.countOfArtistGroupByMonths[0].year,
                        data: this.countOfArtistGroupByMonths ? this.countOfArtistGroupByMonths.map((obj) => obj.data) : null,
                        backgroundColor: [
                            'rgb(243,36,86)',
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
