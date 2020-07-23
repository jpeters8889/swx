import axios from 'axios';
import Application from "../Application";

const request = axios.create();

request.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;

request.interceptors.response.use(
    response => response,
    error => {
        return Promise.reject(error.response);
    }
);

export default request;
