import api from '../../utils/axios';

const extractCount = (response) => {
    return Number(response?.data?.data ?? response?.data ?? 0);
};

export const getUsersCount = async () => {
    const response = await api.get('/users/count');
    return extractCount(response);
};

export const getActiveUsersCount = async () => {
    const response = await api.get('/users/active');
    return extractCount(response);
};

export const getLatestUsers = async () => {
    const response = await api.get('/users/latest');
    return Array.isArray(response?.data?.data) ? response.data.data : [];
};

export const getLeaguesCount = async () => {
    const response = await api.get('/leagues/count');
    return extractCount(response);
};

export const getTeamsCount = async () => {
    const response = await api.get('/teams/count');
    return extractCount(response);
};

export const getFixturesCount = async () => {
    const response = await api.get('/fixtures/count');
    return extractCount(response);
};

export const getFinishedFixturesCount = async () => {
    const response = await api.get('/fixtures/finished');
    return extractCount(response);
};

export const deleteUser = async (id) => {
    return api.delete(`/users/${id}`);
};
