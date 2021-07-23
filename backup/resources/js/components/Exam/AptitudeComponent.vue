<template>
<div>
    <div v-if="loading" class="hiregallaxy_preloader d-flex justify-content-center mt-5 ">
        <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiBzdHlsZT0ibWFyZ2luOiBhdXRvOyBiYWNrZ3JvdW5kOiByZ2IoMjU1LCAyNTUsIDI1NSk7IGRpc3BsYXk6IGJsb2NrOyBzaGFwZS1yZW5kZXJpbmc6IGF1dG87IiB3aWR0aD0iMjAwcHgiIGhlaWdodD0iMjAwcHgiIHZpZXdCb3g9IjAgMCAxMDAgMTAwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJ4TWlkWU1pZCI+CjxjaXJjbGUgY3g9IjUwIiBjeT0iNTAiIHI9IjI2LjM1NzIiIGZpbGw9Im5vbmUiIHN0cm9rZT0iI2U5MGM1OSIgc3Ryb2tlLXdpZHRoPSIyIj4KICA8YW5pbWF0ZSBhdHRyaWJ1dGVOYW1lPSJyIiByZXBlYXRDb3VudD0iaW5kZWZpbml0ZSIgZHVyPSIxcyIgdmFsdWVzPSIwOzQwIiBrZXlUaW1lcz0iMDsxIiBrZXlTcGxpbmVzPSIwIDAuMiAwLjggMSIgY2FsY01vZGU9InNwbGluZSIgYmVnaW49Ii0wLjVzIj48L2FuaW1hdGU+CiAgPGFuaW1hdGUgYXR0cmlidXRlTmFtZT0ib3BhY2l0eSIgcmVwZWF0Q291bnQ9ImluZGVmaW5pdGUiIGR1cj0iMXMiIHZhbHVlcz0iMTswIiBrZXlUaW1lcz0iMDsxIiBrZXlTcGxpbmVzPSIwLjIgMCAwLjggMSIgY2FsY01vZGU9InNwbGluZSIgYmVnaW49Ii0wLjVzIj48L2FuaW1hdGU+CjwvY2lyY2xlPgo8Y2lyY2xlIGN4PSI1MCIgY3k9IjUwIiByPSIyLjAxOTQxIiBmaWxsPSJub25lIiBzdHJva2U9IiM0NmRmZjAiIHN0cm9rZS13aWR0aD0iMiI+CiAgPGFuaW1hdGUgYXR0cmlidXRlTmFtZT0iciIgcmVwZWF0Q291bnQ9ImluZGVmaW5pdGUiIGR1cj0iMXMiIHZhbHVlcz0iMDs0MCIga2V5VGltZXM9IjA7MSIga2V5U3BsaW5lcz0iMCAwLjIgMC44IDEiIGNhbGNNb2RlPSJzcGxpbmUiPjwvYW5pbWF0ZT4KICA8YW5pbWF0ZSBhdHRyaWJ1dGVOYW1lPSJvcGFjaXR5IiByZXBlYXRDb3VudD0iaW5kZWZpbml0ZSIgZHVyPSIxcyIgdmFsdWVzPSIxOzAiIGtleVRpbWVzPSIwOzEiIGtleVNwbGluZXM9IjAuMiAwIDAuOCAxIiBjYWxjTW9kZT0ic3BsaW5lIj48L2FuaW1hdGU+CjwvY2lyY2xlPgo8IS0tIFtsZGlvXSBnZW5lcmF0ZWQgYnkgaHR0cHM6Ly9sb2FkaW5nLmlvLyAtLT48L3N2Zz4=" alt="">
    </div>
    <div v-if="exam_status" class="d-flex justify-content-center mt-5">
        <div class="hiregallaxy__start_exam py-5 d-flex flex-column align-items-center">
            <h1 class="text-danger text-center pb-2">You are Allreay Give Your Skill Test!</h1>
            <a :href="url" class="btn btn-info text-center text-light">
                Go Back & apply job
            </a>
        </div>
    </div>
    <div v-if="error" class="d-flex justify-content-center mt-5">
        <div class="hiregallaxy__start_exam py-5 d-flex flex-column align-items-center">
            <h1 class="text-danger text-center pb-2">Something went wrong! Please Try Again.</h1>
            <a @click="reload" class="btn btn-info text-center text-light">
                Go Back
            </a>
        </div>
    </div>
    <div v-if="!isExamStart && !loading && !exam_status && !error" class="d-flex justify-content-center py-5 mt-5">
        <div class="hiregallaxy__start_exam">
            <button class="btn btn-success" @click="StartExam">
                Exam Start Now
            </button>
        </div>
    </div>
    <div v-if="isExamStart" class="hiregallaxy_main__section d-flex flex-column justify-content-center  w-100">
        <div class="hiregallaxy_main__header d-flex justify-content-between align-items-center">
            <div class="hiregallaxy_time__section d-flex justify-content-between align-items-center">
                <div class="hiregallaxy_time__left d-flex align-items-center">
                    <i class="fa fa-clock-o"></i>
                    <span class="font-weight-bold mx-2">TIME LEFT</span>
                </div>
                <div class="hiregallaxy__time d-flex">00:<timer :time="prettyTime"></timer>
                </div>
            </div>
            <div class="hiregallaxy_complete__section">
                <button @click="PowerButton" v-if="!showResult" class="btn btn-success hiregallaxy_custom_btn  d-flex justify-content-between align-items-center">Ok
                    <i class="fa fa-power-off ml-2"></i>
                </button>
            </div>
        </div>
        <div class="hiregallaxy_main__question d-flex justify-content-start align-items-center" v-if="!showResult">
            <div class="hiregallaxy_pagination__left_side d-flex  align-items-center">
                <i class="fa fa-file-text-o"></i>
                <h5 class="mb-0 mx-3 ">Questions</h5>
            </div>
            <div class="hiregallaxy_main__pagination d-flex">
                <div class="progressContainer">
                    <div class="progress hiregallaxy__progress">
                        <div class="bar" :style="'width:'+ Math.floor((progressIndex/quiz.questions.length)*100)+'%'"></div>
                    </div>
                    <span class="font-weight-bold">{{Math.floor((progressIndex/quiz.questions.length)*100)}}%</span>
                </div>
            </div>
        </div>
        <div v-if="!showResult" class="hiregallaxy_main__answer">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hiregallaxy_left__side text-left">
                        <div class="hiregallaxy_question__no d-flex align-items-center justify-content-start">
                            <h5 class="m-0 font-weight-bold">Questions # {{questionIndex+1}} / {{quiz.questions.length}}</h5>
                            <button :disabled="question != ''" class="btn btn-success  hiregallaxy_custom_btn  d-flex justify-content-center ml-4 align-items-center" @click="SkipQuestion(questionIndex)">Skip for now</button>
                        </div>
                        <h5 class="hiregallaxy_question__alert m-0 py-4">Carefully read the question and answer accordingly. </h5>
                        <p class="hiregallaxy__question m-0 font-weight-bold">{{questionIndex+1}}. <span class="question__image" v-html="quiz.questions[questionIndex].questions"></span></p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hiregallaxy_right__side mt-5 mt-lg-0">
                        <h5 class="hiregallaxy_choose mb-3">
                            Choose Best Option`
                        </h5>
                        <div class="hiregallaxy__options">
                            <span class="d-none question_id" :data-questionid="quiz.questions[questionIndex].id"></span>
                            <div class="form-check" v-for="(response, index) in quiz.questions[questionIndex].responses" :key="index">
                                <input class="form-check-input" type="radio" name="question" v-model="question" :id="'question_'+index" :value="index">
                                <label class="form-check-label" :for="'question_'+index">
                                    {{ response }}
                                </label>
                            </div>
                        </div>
                        <div class="hiregallaxy_clear_response" @click="uncheck">
                            Clear Response
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!showResult" class="hiregallaxy_main__footer d-flex justify-content-lg-end justify-content-center">
            <div class="hiregallaxy__previous">
                <button v-on:click="prev();" :disabled="questionIndex < 1" class="btn btn-success hiregallaxy_custom_btn  d-flex justify-content-between align-items-center">
                    <i class="fa fa-arrow-left mr-1"></i>
                    Prev Questions
                </button>
            </div>
            <div class="hiregallaxy__next ml-3">
                <button :disabled="question == ''" v-if="!queIndex" class="btn btn-success hiregallaxy_custom_btn  d-flex justify-content-between align-items-center" v-on:click="next();">
                    Next Question
                    <i class="fa fa-arrow-right ml-1"></i>
                </button>
                <button v-if="queIndex" :disabled="question == ''" @click="fineshedExam" class="text-center btn btn-success hiregallaxy_custom_btn  d-flex justify-content-between align-items-center">Finished</button>
            </div>
        </div>
        <div class="hiregallaxy__submit_result d-flex justify-content-center my-5 py-5" v-if="showResult">
            <button @click="submitResult" class="btn btn-success">Submit & Apply Job</button>
        </div>
    </div>
</div>
</template>

<script>
import {
    bus
} from "../../app";
import Axios from 'axios';

let Timer = {
    template: `

 <div class="timer">{{ time | prettify }}</div>

`,
    props: ['time'],
    filters: {
        prettify: function (value) {
            let data = value.split(':')
            let minutes = data[0]
            let secondes = data[1]
            if (minutes < 10) {
                minutes = "0" + minutes
            }
            if (secondes < 10) {
                secondes = "0" + secondes
            }
            return minutes + ":" + secondes
        }
    }
}
export default {
    props: ['url', 'id'],
    mounted() {
        var app = this;
    },
    components: {
        'timer': Timer
    },
    data() {
        return {
            beforeunload: false,
            exam_status: false,
            status: [],
            isExamStart: false,
            loading: false,
            showResult: false,
            minutes: 30,
            secondes: 0,
            time: 0,
            timer: null,
            sound: new Audio("http://s1download-universal-soundbank.com/wav/nudge.wav"),
            quiz: {},
            questionIndex: 0,
            progressIndex: 1,
            quizStarted: true,
            isActive: false,
            question: '',
            question_id: null,
            answer: [],
            error: false,
        };
    },
    computed: {
        prettyTime() {
            let time = this.time / 60
            let minutes = parseInt(time)
            let secondes = Math.round((time - minutes) * 60)
            return minutes + ":" + secondes
        },
        queIndex() {
            return this.questionIndex == this.quiz.questions.length - 1;
        },
        chooseSelected() {
            return this.questionIndex == this.quiz.questions.length - 1;
        }
    },
    methods: {
        StartExam() {
            const status = this.status.some(el => el.job_id == this.id)
            if (status) {
                this.exam_status = true
                return
            }

            let result = confirm("Are You Sure To Start Test Your Skill?");
            if (result) {
                this.loading = true
                this.fetchData();
            }
        },
        start() {
            if (!this.timer) {
                this.alert();
                this.timer = setInterval(() => {
                    if (this.time > 0) {
                        this.time--
                    } else {
                        clearInterval(this.timer)
                        this.sound.play()
                        this.showResult = true
                    }
                }, 1000)
            }
        },
        PowerButton() {
            let result = confirm("Are You Sure To Stop Your Exam?");
            if (result) {
                clearInterval(this.timer)
                this.showResult = true
            }
        },
        next: function () {
            if (this.questionIndex < this.quiz.questions.length - 1)
                this.questionIndex++;
            this.progressIndex++;
            this.getQuestionId();
            this.storeAnswer();

        },
        prev: function () {
            if (this.quiz.questions.length > 0) this.questionIndex--;
            this.progressIndex--;
            this.getQuestionId('prev');
        },
        SkipQuestion(lastIndex) {
            if (this.questionIndex < this.quiz.questions.length - 1)
                this.questionIndex++;
            this.progressIndex++;
            this.getQuestionId();
            if (Array.isArray(this.answer) && this.answer.length !== 0) {
                this.answer = this.answer.filter((e) => e.id !== this.question_id)
            }
            if (this.quiz.questions.length - 1 === lastIndex) {
                this.showResult = true
                clearInterval(this.timer)
            }
        },
        uncheck: function () {
            if (this.question) {
                this.question = ''
            }
            this.answer = this.answer.filter(el => el.id !== this.question_id);
        },
        alert() {
            window.addEventListener('beforeunload', (event) => {
                if (this.beforeunload)
                    event.returnValue = `Are you sure you want to leave?`;

            });
        },
        fetchData() {
            Axios.get('/candidates/aptitude/questions/' + this.id).then(async (res) => {
                if (res.data.error == 'error') {
                    this.loading = false;
                    this.error = true;
                } else {
                    this.quiz = await {
                        id: res.data.id,
                        user: res.data.user,
                        questions: res.data[0]
                    }
                    if (JSON.stringify(this.quiz) !== '{}') {
                        this.loading = false;
                        this.isExamStart = true
                        this.beforeunload = true
                        this.start();
                        this.getQuestionId();
                    }
                }

            });
        },
        getQuestionId(value = 'next') {
            setTimeout(() => {
                let question_id = document.querySelector('.question_id');
                if (question_id != null) {
                    question_id = question_id.getAttribute('data-questionid');
                    this.question_id = question_id;
                    if (value == 'prev') {
                        if (Array.isArray(this.answer) && this.answer.length !== 0) {
                            this.answer.map(el => {
                                if (el.id == this.question_id) {
                                    this.question = el.question
                                }
                            });
                        }
                    }
                }
            }, 50)
        },
        fineshedExam() {
            this.storeAnswer()
            this.showResult = true
            clearInterval(this.timer)
        },
        storeAnswer() {
            const data = {
                id: this.question_id,
                question: this.question
            }
            if (!this.answer.some(el => el.id === data.id)) {
                this.answer.push(data)
            } else {
                this.answer.filter(el => {
                    if (el.id == this.question_id) {
                        el.question = this.question
                    }
                });
            }
            this.question = '';
        },
        submitResult() {
            this.beforeunload = false
            let data = {
                user_id: this.quiz.id,
                total: this.quiz.questions.length,
                seconds: this.time,
                answer: this.answer,
                job_id: this.id
            }
            Axios.post('/candidates/aptitude/result/', data).then((res) => {
                if (res.data.success == 'success') {
                    window.location = 'https://joblrs.com/jobs/view/' + res.data.job_id.slug;
                }
            });
        },
        user_finished_exam() {
            Axios.get('/candidates/aptitude/check-status').then((res) => {
                this.status = res.data
            });
        },
        reload() {
            window.location.reload()
        }
    },
    created() {
        this.time = (this.minutes * 60 + this.secondes)
        this.user_finished_exam();
    }

};
</script>

<style>
.question__image img {
    width: 100%;
    height: auto;
}

.hiregallaxy_main__section {
    border: 1px solid #e6e6e6;
    margin-top: 50px;
    padding: 0px;
    box-shadow: 0px 1px 17px -9px #2b2b2b87;
}

.hiregallaxy_main__section .hiregallaxy_main__header {
    padding: 10px;
    background: #555;
}

.hiregallaxy_main__section .hiregallaxy_time__left i {
    color: #61c866;
    font-size: 28px;
}

.hiregallaxy_main__section .hiregallaxy_time__left span {
    color: #bdbdbd;
    font-size: 16px;
}

.hiregallaxy_main__section .hiregallaxy__time {
    color: #fff;
    font-size: 16px;
}

.hiregallaxy_main__section .hiregallaxy_custom_btn {
    width: 180px;
    height: 45px;
    background: #ff7c39;
    border: none;
    border-radius: 40px;
    color: white;
    display: flex !important;
    justify-content: center !important;
}

.hiregallaxy_main__section .hiregallaxy_custom_btn:hover {
    background: #f0641c;
}

.hiregallaxy_main__section .hiregallaxy_custom_btn:focus {
    box-shadow: none;
    outline: none;
}

.hiregallaxy_main__section .hiregallaxy_main__question {
    background: #fff;
    padding: 0px 10px;
    box-shadow: 0px 5px 7px -7px #171717ab;
    width: 100%
}

.hiregallaxy_main__section .hiregallaxy_main__answer {
    padding: 60px 0;
}

.hiregallaxy_main__section .hiregallaxy_pagination__left_side {
    padding: 15px 0px;
}

.hiregallaxy_main__section .hiregallaxy_pagination__left_side i {
    font-size: 24px;
    color: #3c3c3c;
}

.hiregallaxy_main__section .hiregallaxy_pagination__left_side h5 {
    font-size: 18px;
    color: #61c866;
    font-weight: bold;
}

.hiregallaxy_main__section .hiregallaxy_main__pagination {
    padding-left: 45px;
    width: 100%;
}

.hiregallaxy_left__side.text-left {
    padding-left: 10px;
}

.hiregallaxy_main__section .hiregallaxy_main__pagination .progressContainer {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.hiregallaxy_main__section .hiregallaxy__progress {
    width: 90%;
    border-radius: 10px;
    border: none;
    transition: 1s all ease-in-out;
}

.progress {
    margin: 20px auto;
    padding: 0;
    width: 90%;
    height: 10px;
    overflow: hidden;
    background: #eeeeee;
    border-radius: 6px;
}

.bar {
    position: relative;
    float: left;
    min-width: 0%;
    height: 100%;
    background: #61c866;
}

.percent {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    margin: 0;
    font-family: tahoma, arial, helvetica;
    font-size: 12px;
    color: white;
}

.hiregallaxy_main__section .hiregallaxy_question__alert {
    font-size: 18px;
    color: #535353;
}

.hiregallaxy_main__section .hiregallaxy__question {
    font-size: 18px;
    color: #535353;
}

.hiregallaxy_main__section .hiregallaxy_right__side {
    padding: 0 30px;
}

.hiregallaxy_main__section .hiregallaxy__options {
    padding-left: 25px;
}

.hiregallaxy_main__section .hiregallaxy_choose {
    font-weight: 900;
    color: #313131;
}

.hiregallaxy_main__section .hiregallaxy_clear_response {
    font-size: 16px;
    color: #61c866;
    padding: 20px 0px;
    cursor: pointer;
}

.hiregallaxy_main__section .hiregallaxy__options .form-check {
    padding: 2px 20px;

}

.hiregallaxy_main__section .hiregallaxy__options .form-check-label {
    margin-top: 2px;
    cursor: pointer;
}

.hiregallaxy_main__section .hiregallaxy__options input {
    cursor: pointer;
}

.hiregallaxy_main__section .hiregallaxy_main__footer {
    padding: 10px;
}

.hiregallaxy_right__side {
    border-left: 1px solid #e4e4e4;
}

.hiregallaxy_main__section [disabled="disabled"] {
    cursor: not-allowed;
}

@media only screen and (max-width: 600px) {
    .hiregallaxy_main__section .hiregallaxy_right__side {
        padding: 0px;
        padding-left: 10px;
    }

    .hiregallaxy_main__section .hiregallaxy_custom_btn {
        width: 150px;
        height: 40px;
    }

    .hiregallaxy_right__side {
        border-left: none;
    }
}
</style>
