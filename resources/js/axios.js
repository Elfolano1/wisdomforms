
import axios from "axios";

import router from "./router/index.js";

const axiosClient = axios.create({
  baseURL:  `wisdomforms.test/api`
})




export default axiosClient;
