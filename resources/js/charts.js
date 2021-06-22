import Vue from "vue";
import HighchartsVue from "highcharts-vue";
Vue.use(HighchartsVue);
import Chart from "./components/Chart";

const Content = new Vue({
    el: '#app',
    components: { Chart  }

});
