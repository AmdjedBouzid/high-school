import axios from "axios";
import { DOMAIN } from "./constants";
const axiosInstance = axios.create({
  baseURL: `${DOMAIN}/api`,
  headers: {
    "Content-Type": "application/json",
  },
});

// Request interceptor
axiosInstance.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("token");
    if (config.headers) {
      config.headers["Authorization"] = `Bearer ${token}`;
      config.headers["Accept"] = "application/json";
    } else {
      config.headers = {
        Authorization: `Bearer ${token}`,
      };
    }

    console.log("Request sent", config);
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Response interceptor
axiosInstance.interceptors.response.use(
  (response) => {
    console.log("Response received", response);
    return response;
  },
  (error) => {
    console.error("Response error", error);
    return Promise.reject(error);
  }
);

export default axiosInstance;
