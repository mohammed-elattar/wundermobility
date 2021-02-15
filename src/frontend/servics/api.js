import Vue from "vue";
import axios from "axios";

const instance = axios.create({
    baseURL: "https://backend.wundermobility.task/api/"
});

instance.interceptors.response.use(
    response => response,
    error => {
        if (error.response.status == 404) {
            Vue.$toast.error("Not Found");
        }
        return Promise.reject(error);
    }
);

export default instance;
