<template>
<div>
    <div class="filter">
        <ul class="filter__ul">
            <li>
                <button class="filter__ul--all-time " :class="allActive ? 'active-fliter': '' " @click="allTimeData">All Time</button>
            </li>

            <li>
                <button class="filter__ul--weekly" :class="weeklyActive ? 'active-fliter': '' " @click="WeeklyData">Weekly</button>
            </li>
            <li>
                <div class="form-group">
                    <select class="form-control" @change="YearlyData" v-model="year">
                        <option value="">Year</option>
                        <option v-for="(year, index) in years" :key="index" :value="year">{{year}}</option>
                    </select>
                </div>
            </li>
            <li>
                <div class="form-group">
                    <select class="form-control" @change="MonthlyData" v-model="month">
                        <option value="">Month</option>
                        <option v-for="(month, index) in months" :key="index" :value="month">{{month}}</option>
                    </select>
                </div>
            </li>
        </ul>
    </div>
    <chart :data='filters.datas' :assign='assign' :team="team_id"></chart>
</div>
</template>

<script>
import chart from './ChartComponent'
export default {
    components: {
        chart
    },
    props: ['assign', 'team_id'],
    data() {
        return {
            years: [],
            months: ['January', 'February', 'March',
                'April', 'May', 'June', 'July',
                'August', 'September', 'October', 'November', 'December'
            ],
            month: '',
            year: '',
            filters: {
                datas: []
            },
            allActive: true,
            weeklyActive: false,
        }
    },
    methods: {
        getyear() {
            const currentYear = (new Date()).getFullYear();
            const range = (start, stop, step) => Array.from({
                length: (stop - start) / step + 1
            }, (_, i) => start + (i * step));
            this.years = range(currentYear, currentYear - 10, -1);
        },

        allTimeData() {
            if (this.allActive != true) {
                let url = "/api/employer/datas";
                let vm = this;
                axios.get(url, {
                    params: {
                        assign: vm.assign,
                        team_id: vm.team_id
                    }
                }).then(res => {
                    this.filters.datas = res.data
                });
                this.allActive = true;
                this.weeklyActive = false;
                this.year = '';
                this.month = '';
            }
        },
        WeeklyData() {
            if (this.weeklyActive != true) {
                let url = "/api/employer/datas/weekly";
                let vm = this;
                axios.get(url, {
                    params: {
                        assign: vm.assign,
                        team_id: vm.team_id
                    }
                }).then(res => {
                    this.filters.datas = res.data
                });
                this.allActive = false;
                this.weeklyActive = true;
                this.year = '';
                this.month = '';
            }

        },
        YearlyData() {
            let url = "/api/employer/datas/yearly";
            let vm = this;
            axios.get(url, {
                params: {
                    year: vm.year,
                    assign: vm.assign,
                    team_id: vm.team_id
                }
            }).then(res => {
                this.filters.datas = res.data
            });
            this.allActive = false;
            this.weeklyActive = false;
            this.month = '';
        },
        MonthlyData(e) {
            let url = "/api/employer/datas/monthly";
            let vm = this;
            axios.get(url, {
                params: {
                    year: vm.year,
                    month: vm.month,
                    assign: vm.assign,
                    team_id: vm.team_id
                }
            }).then(res => {
                this.filters.datas = res.data
            });
            this.allActive = false;
            this.weeklyActive = false;
        }
    },
    mounted() {
        this.getyear();
    }
}
</script>

<style lang="scss">
.filter {
    margin: 15px 0;

    &__ul {
        list-style: none;
        display: flex;
        margin: 0;
        padding: 0;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;

        li {
            margin: 5px 5px;
        }

        .form-control {
            margin: 0;
        }

        &--all-time {
            border: none;
            padding: 5px;
            background: #f9f9f9;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 8px 20px;

            &:hover {
                background: #e9e9e9;
            }
        }

        &--weekly {
            border: none;
            padding: 5px;
            background: #f9f9f9;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 8px 20px;

            &:hover {
                background: #e9e9e9;
            }
        }

        .form-group {
            margin: 0;

            .form-control {
                width: 150px;
                max-width: 100%;
            }
        }
    }

    .active-fliter {
        background: #e9e9e9;
    }
}
</style>
