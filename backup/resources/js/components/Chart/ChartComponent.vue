<script>
import {
    Bar
} from 'vue-chartjs'

export default {
    extends: Bar,
    props: {
        data: {
            type: Array,
            required: false,
        },
        assign: {
            type: Boolean,
            required: false
        },
        team: {
            type: String,
            required: false
        }
    },
    data() {
        return {
            suggest: 200,
            datas: []
        }
    },
    watch: {
        'data': function (res) {
            this.datas = res;
            this.chartRender()
        }
    },
    methods: {
        chartRender() {
            this.renderChart({
                labels: ['Posted', 'Companies', 'Applications', 'New Applications', 'Shortlisted Candidates', 'Interviews', 'Offered', 'Hired', 'Rejected'],
                datasets: [{
                    backgroundColor: '#4f48b2',
                    data: this.datas
                }]
            }, {
                "hover": {
                    "animationDuration": 0
                },
                "animation": {
                    "duration": 1,
                    "onComplete": function () {
                        var chartInstance = this.chart,
                            ctx = chartInstance.ctx;

                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';

                        this.data.datasets.forEach(function (dataset, i) {
                            var meta = chartInstance.controller.getDatasetMeta(i);
                            meta.data.forEach(function (bar, index) {
                                var data = dataset.data[index];
                                ctx.fillText(data, bar._model.x, bar._model.y - 5);
                            });
                        });
                    }
                },
                legend: {
                    display: false,
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: this.suggest
                        }
                    }],
                },
            });
        }
    },
    mounted() {
        let url = "/api/employer/datas";
        let vm = this;
        axios.get(url, {
            params: {
                assign: vm.assign,
                team_id: vm.team,
            }
        }).then(res => {
            this.datas = res.data
            this.chartRender()
        });
    }
}
</script>
