<template>
    <div class="container paddings-mini">
        <highcharts class="hc" :options="chartOptions" ref="chart"></highcharts>
    </div>
</template>

<script>
export default {
    name: "Chart",
    props: ['collection', 'days'],
    data() {
        return {
            chartOptions: {
                title: {
                  text: 'Daily Rank Chart',
                },
                yAxis: {
                    title: {
                        text: 'Steps'
                    }
                },
                xAxis: {
                    categories: []
                },
                series: [
                ]
            }
        };
    },
    mounted() {
        this.chartOptions.series = this.collection;
        this.chartOptions.xAxis.categories = this.days;
    }

}
</script>

<style scoped>

</style>
