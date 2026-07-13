import axios from 'axios';
import { toastError, toastSuccess } from './toast';

const api = axios.create({
    baseURL: import.meta.env.VITE_ADMIN_API_BASE_URL || '/api/admin',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'x-api-key': 'api_3Hk9mP7xQ2vL8nY5rT6zB1wC4sD0eF'
    }
});

api.interceptors.request.use((config) => {
    const token = localStorage.getItem('admin_token')
        || localStorage.getItem('auth_token')
        || localStorage.getItem('token');

    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }

    config.headers.Accept = 'application/json';

    return config;
});

const getValidationMessage = (errors) => {
    if (!errors || typeof errors !== 'object') {
        return null;
    }

    const firstError = Object.values(errors)[0];

    if (Array.isArray(firstError)) {
        return firstError[0] || null;
    }

    return typeof firstError === 'string' ? firstError : null;
};

api.interceptors.response.use(
    (response) => {
        const method = response.config?.method?.toLowerCase();
        const mutationMethods = ['post', 'put', 'patch', 'delete'];
        const message = response.data?.message;

        if (mutationMethods.includes(method) && message) {
            toastSuccess(message);
        }

        return response;
    },
    (error) => {
        const status = error.response?.status;
        const responseData = error.response?.data;
        const validationMessage = getValidationMessage(responseData?.errors);
        const message = responseData?.message
            || responseData?.error
            || validationMessage
            || 'Something went wrong. Please try again.';
        const method = error.config?.method?.toLowerCase();
        const shouldNotify = method !== 'get';

        if (!error.response) {
            if (shouldNotify) {
                toastError('Network error. Please check your connection.');
                error.__toastShown = true;
            }
        } else if (status === 401) {
            toastError('Your session has expired. Please login again.');
            error.__toastShown = true;
            localStorage.removeItem('auth_token');
            localStorage.removeItem('token');
            localStorage.removeItem('admin_token');
            localStorage.removeItem('admin_user');
            delete api.defaults.headers.common.Authorization;

            if (window.location.pathname !== '/admin/login') {
                window.location.href = '/admin/login';
            }
        } else if (shouldNotify) {
            if (status === 403) {
                toastError('You do not have permission to perform this action.');
            } else if (status === 404) {
                toastError('The requested resource was not found.');
            } else if (status === 422) {
                toastError(validationMessage || message);
            } else if (status >= 500) {
                toastError('Server error. Please try again later.');
            } else {
                toastError(message);
            }

            error.__toastShown = true;
        }

        return Promise.reject(error);
    }
);

export default api;
