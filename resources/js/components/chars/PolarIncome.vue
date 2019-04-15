<script>
import { VueCharts, VueChartJs } from "vue-chartjs";

export default {
  extends: VueCharts.PolarArea,
  mixins: [VueCharts.mixins.reactiveProp],
  props:{
      max: Number
  },
  data: function() {
    return {
      options: {

        legend: {
          display: true,
          position: "right"
        },
        tooltips: {
          enabled: true,
          mode: "single",
          callbacks: {
            label: function(tooltipItems, data) {
              return "" + tooltipItems.yLabel;
            }
          }
        },
        responsive: true,
        maintainAspectRatio: false,
        height: 200
      }
    };
  },
  mounted() {
    // this.chartData is created in the mixin
    this.renderChart(this.chartData, this.options);
  },

};
</script>
