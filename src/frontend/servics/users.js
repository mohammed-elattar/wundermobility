import Vue from "vue";
import api from "./api";

export const registerUser = payload =>
    api
        .post(`users`, payload)
        .then(() => Vue.$toast.success("User has been registered successfully"));
