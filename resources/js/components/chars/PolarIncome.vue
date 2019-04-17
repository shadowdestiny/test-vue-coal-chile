<script>
import { VueCharts, VueChartJs } from "vue-chartjs";

export default {
  extends: VueCharts.Pie,
  mixins: [VueCharts.mixins.reactiveProp],
  props:{
      max: Number
  },
  data: function() {
    return {
      options: {
        responsive: true,
        maintainAspectRatio: false,
        pieceLabel: {
          mode: 'percentage',
          precision: 2,
        },
        tooltips: {
          enabled: true,
          callbacks: {
              label:function (tooltipItem, data) {
                  let dataset = data.datasets[tooltipItem.datasetIndex]
                  let currentValue = dataset.data[tooltipItem.index]
                  return currentValue + ' %'
              }
          }
        }
      }
    };
  },
  mounted() {
    // this.chartData is created in the mixin
    this.renderChart(this.chartData, this.options);
  },

};
</script>
