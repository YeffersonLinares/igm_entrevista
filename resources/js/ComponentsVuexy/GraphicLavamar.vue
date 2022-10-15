<template>
    <div class="d-flex justify-content-center" :id="id"></div>
</template>
<script>
import { defineComponent } from 'vue'
export default defineComponent({
    props: {
        title: String,
        rows: Array,
        text: String,
        id: String,
        type: {
            type: String,
            default: 'bars'
        },
    },
    created() {
        this.getResults()
    },
    methods: {
        getResults() {
            let that = this
            google.charts.load("current", { packages: ["corechart"] });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                let rows = []
                Object.values(that.rows).forEach(element => {
                    rows.push(Object.values(element))
                });
                let data = new google.visualization.arrayToDataTable(rows);
                let options = { title: that.title, width: 600, height: 450 };


                //Diagrama de barras
                // let graphic = new google.visualization.BarChart(
                // Diagrama de torta
                // let graphic = new google.visualization.PieChart(
                // Diagrama de area 1 vs 1
                // let graphic = new google.visualization.AreaChart(

                let graphic = null
                console.log('that.type ==> ', that.type)
                if (that.type == 'pie') {
                    graphic = new google.visualization.PieChart(document.querySelector("#" + that.id));
                } else if (that.type == 'bars') {
                    graphic = new google.visualization.BarChart(document.querySelector("#" + that.id));
                } else if (that.type == 'area') {
                    graphic = new google.visualization.AreaChart(document.querySelector("#" + that.id));
                }
                graphic.draw(data, options);
            }
        },
    },
    destroyed() {
        this.getResults()
    },
});
</script>

<style lang="css">

</style>
