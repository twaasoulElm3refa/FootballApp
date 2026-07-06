import api from '../utils/axios';

export const getUsersCount = async () => {
    const response = await api.get('/users/count');

    return response.data?.data ?? 0;
};
