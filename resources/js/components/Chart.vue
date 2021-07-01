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
                series: []
            }
        };
    },
    mounted() {
        let i = 1;
        this.chartOptions.series = this.collection
            .sort(function (a, b) {
                return a.steps < b.steps;
            })
            .map(function (col) {
                if (i > 7) {
                    col.visible = false;
                }
                i++;
                return col;
            });
        this.chartOptions.xAxis.categories = this.days;
    }

}
</script>

<style scoped>

</style>
