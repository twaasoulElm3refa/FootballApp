import axios from 'axios';

const axiosInstance = axios.create({
    baseURL: '/api/admin',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'x-api-key': 'api_3Hk9mP7xQ2vL8nY5rT6zB1wC4sD0eF'
    }
});

axiosInstance.interceptors.request.use(config => {
    const token = localStorage.getItem('admin_token');

    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }

    config.headers.Accept = 'application/json';

    return config;
});

axiosInstance.interceptors.response.use(
    response => response,
    error => {
        if (error.response && error.response.status === 401) {
            localStorage.removeItem('admin_token');
            localStorage.removeItem('admin_user');
            delete axiosInstance.defaults.headers.common['Authorization'];

            if (window.location.pathname !== '/admin/login') {
                window.location.href = '/admin/login';
            }
        }
        return Promise.reject(error);
    }
);

export default axiosInstance;
