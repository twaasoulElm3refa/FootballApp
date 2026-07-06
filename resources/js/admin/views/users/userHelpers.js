export const roleOptions = ['admin', 'user'];

export const languageOptions = ['en', 'ar'];

export const statusOptions = ['active', 'suspended', 'deleted'];

export const timezoneOptions = [
    'UTC',
    'Africa/Cairo',
    'Europe/London',
    'America/New_York',
    'Asia/Dubai',
];

export const getUserName = (user) => user?.username || user?.name || '-';

export const formatDate = (value) => {
    if (!value) {
        return '-';
    }

    const date = new Date(value);

    if (Number.isNaN(date.getTime())) {
        return value;
    }

    return new Intl.DateTimeFormat('en', {
        dateStyle: 'medium',
        timeStyle: 'short',
    }).format(date);
};

export const getErrorMessage = (error, fallback = 'Something went wrong. Please try again.') => {
    return error?.response?.data?.message || error?.message || fallback;
};

export const getValidationErrors = (error) => {
    return error?.response?.data?.errors || {};
};

export const firstError = (errors, field) => {
    const value = errors?.[field];

    if (Array.isArray(value)) {
        return value[0];
    }

    return value || '';
};

export const emptyUserForm = () => ({
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'user',
    language: 'en',
    timezone: 'UTC',
    status: 'active',
});
