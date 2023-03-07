import {defineStore} from "pinia";
//import { useToast } from "vue-toastification";
//import axiosClient from "@/axios";
import axios from "axios";


//const toast = useToast();

export const useAuthStore = defineStore('auth',{
    state:()=>({
        user: {
            token: sessionStorage.getItem('TOKEN'),
            data: {}
          },
    }),
    getters:{

    },
    actions:{

       async login(data) {
           console.log("Store Data",data);
            return axios.post('/api/login', data)
              .then((data) => {
                //  console.log(data);
                this.user.token=data.token;
                this.user.data=data.user;
                return data;
              })
          },

         async logout() {
            return axios.post('/logout')
              .then((response) => {
                this.user.token=null;
                return response;
              })
          },

         async getCurrentUser( data) {
            return axiosClient.get('/user', data)
              .then(({data}) => {
                this.user.data=data.user;
                return data;
              })
          }

    }
})


