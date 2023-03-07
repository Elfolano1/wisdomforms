import { defineStore } from "pinia";
// import axiosClient from "../axios";
import axios from "axios";

export const usestore = defineStore({
    id: "statestore",
    state: () => ({
        InterviewForms: {
            loading: false,
            data: [],
            links: [],
            from: null,
            to: null,
            page: 1,
            limit: null,
            total: null,
            length: 0,
        },
        InterviewForm: null,
        loading: false,
        error: null,
        codeResponse: null,
        countsignedforms:0,
        countPendingValidation:0,
        countPendingSignature:0,
        countAll:0
    }),
    getters: {},
    actions: {
        async getInterviewForms({ url = null, search = '', per_page ,status=0} = {}) {
            this.InterviewForms = []
            this.InterviewForms.loading = true
            url = url || '/api/interviewform'
            console.log(url)
            const params = {
                per_page: 10,
            }
            try {
                await axios.get(url, {
                    params: {
                        search, per_page,status
                    }
                }).then((resp) => {
                    this.InterviewForms.length = resp.data.data.length
                    this.InterviewForms.data = resp.data.data
                    this.InterviewForms.links = resp.data.meta.links
                    this.InterviewForms.from = resp.data.meta.from
                    this.InterviewForms.to = resp.data.meta.to
                    this.InterviewForms.page = 1
                    this.InterviewForms.limit = resp.data.meta.per_page
                    this.InterviewForms.total = resp.data.meta.total
                })


            } catch (error) {
                this.error = error
            } finally {
                this.InterviewForms.loading = false
            }
        },
        async getform(id) {
            
                await axios.get(`/api/interviewform/${id}`).then((resp) => {
                    this.InterviewForm = resp.data.data
                });

            
        },
        async verifycode(data) {
            this.loading = true
            try {
                await axios.post('/api/verificationcode', data).then((resp) => {
                    this.codeResponse = resp.data
                })

            } catch (error) {
                this.error = error
            } finally {
                this.loading = false
            }

        },
        async generatecode() {
            try {
                await axios.get('/api/verificationcode')
            } catch (error) {

            }
        },
        async createInterviewForms(data) {
            this.loading = true

            try {
                await axios.post('/api/interviewform', data).then((resp) => {
                    this.InterviewForm = resp.data.data
                })

            } catch (error) {
                this.error = error
            } finally {
                this.loading = false
            }

        },
        async updateInterviewForms(data) {
            this.loading = true

            try {
                await axios.put('/api/interviewform/' + data.id, data).then((resp) => {
                    this.InterviewForm = resp.data.data
                })

            } catch (error) {
                this.error = error
            } finally {
                this.loading = false
            }

        },
        async validateInterviewForms(data) {
            try {
                await axios.put('/api/validateinterviewform/' + data.id).then((resp) => {

                })
            } catch (error) {

            }
        },
        async convertTocaregiver(id){
            await axios.get(`/api/convertTocaregiver/${id}`)
        },
        async counter(id){
            await axios.get('/api/countinterviewform').then((resp)=>{
                this.countAll=resp.data.countAll
                this.countsignedforms=resp.data.countSigned
                this.countPendingSignature=resp.data.countPendingSignature
                this.countPendingValidation=resp.data.countPendingValidation
            })
        }
    },

})

