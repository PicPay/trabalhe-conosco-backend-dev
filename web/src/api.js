import Axios from 'axios';

const axios = Axios.create({ baseURL: 'http://localhost:8000' });

axios.interceptors.request.use((config) => {
  const accessToken = localStorage.getItem('access_token');
  if (accessToken) config.headers.common['Authorization'] = `Bearer ${accessToken}`;
  return config;
}, (error) => Promise.reject(error));

export default axios;
