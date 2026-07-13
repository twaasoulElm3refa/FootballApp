import api from '../../utils/axios';

const emptyPagination = () => ({
    items: [],
    currentPage: 1,
    lastPage: 1,
    perPage: 10,
    total: 0,
    from: null,
    to: null,
    links: [],
});

export const getLeagues = async (params = {}) => {
    const response = await api.get('/leagues', { params });
    const pagination = response?.data?.data;

    if (!pagination || typeof pagination !== 'object') {
        return emptyPagination();
    }

    return {
        items: Array.isArray(pagination.data) ? pagination.data : [],
        currentPage: Number(pagination.current_page) || 1,
        lastPage: Number(pagination.last_page) || 1,
        perPage: Number(pagination.per_page) || 10,
        total: Number(pagination.total) || 0,
        from: pagination.from ?? null,
        to: pagination.to ?? null,
        links: Array.isArray(pagination.links) ? pagination.links : [],
    };
};

export const getTopLeagues = async () => {
    const response = await api.get('/leagues/top');
    return Array.isArray(response?.data?.data) ? response.data.data : [];
};

export const getLeague = async (id) => {
    const response = await api.get(`/leagues/${id}`);
    const league = response?.data?.data;

    return league && typeof league === 'object' ? league : {};
};

export const createLeague = async (payload) => {
    const response = await api.post('/leagues', payload);
    return response.data;
};

export const updateLeague = async (id, payload) => {
    const response = await api.put(`/leagues/${id}`, payload);
    return response.data;
};

export const deleteLeague = async (id) => {
    const response = await api.delete(`/leagues/${id}`);
    return response.data;
};
