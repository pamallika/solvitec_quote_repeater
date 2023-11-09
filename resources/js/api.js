import axios from "axios";
// import router from "@/router.js";

const api = axios.create();

api.interceptors.request.use(config => {
    if (localStorage.getItem('api_token')) {
        config.headers = {
            'authorization': `Bearer ${localStorage.getItem('api_token')}`
        }
    }

    return config;
}, error => {})
api.interceptors.response.use(config => {
    if (localStorage.getItem('api_token')) {
        config.headers = {
            'authorization': `Bearer ${localStorage.getItem('api_token')}`
        }
    }
    return config;
}, error => {
    if (error.response.status === 401) {
        // router.push('/api/login');
    }

    if (error.response.status === 404) {
        alert('404 NotFound');
    }
})
export default api
