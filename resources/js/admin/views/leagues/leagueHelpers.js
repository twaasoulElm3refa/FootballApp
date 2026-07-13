export const createEmptyLeagueForm = () => ({
    api_league_id: '',
    name: '',
    type: '',
    country: '',
    logo: '',
    flag: '',
    season: '',
    is_active: true,
    is_featured: false,
    sort_order: 0,
    has_standings: false,
    meta: '',
});

export const normalizeFormNumber = (value) => {
    if (value === '' || value === null || value === undefined) {
        return null;
    }

    return Number(value);
};

export const parseMeta = (metaText) => {
    if (!metaText || !metaText.trim()) {
        return null;
    }

    const parsedMeta = JSON.parse(metaText);

    if (!parsedMeta || typeof parsedMeta !== 'object' || Array.isArray(parsedMeta)) {
        throw new Error('Meta must be a JSON object.');
    }

    return parsedMeta;
};

const normalizeText = (value) => {
    const normalized = String(value ?? '').trim();
    return normalized || null;
};

export const buildLeaguePayload = (form) => ({
    api_league_id: Number(form.api_league_id),
    name: String(form.name ?? '').trim(),
    type: normalizeText(form.type),
    country: normalizeText(form.country),
    logo: normalizeText(form.logo),
    flag: normalizeText(form.flag),
    season: normalizeFormNumber(form.season),
    is_active: Boolean(form.is_active),
    is_featured: Boolean(form.is_featured),
    sort_order: Number(form.sort_order) || 0,
    has_standings: Boolean(form.has_standings),
    meta: parseMeta(form.meta),
});

export const populateLeagueForm = (league) => ({
    api_league_id: league.api_league_id ?? '',
    name: league.name ?? '',
    type: league.type ?? '',
    country: league.country ?? '',
    logo: league.logo ?? '',
    flag: league.flag ?? '',
    season: league.season ?? '',
    is_active: Boolean(league.is_active),
    is_featured: Boolean(league.is_featured),
    sort_order: league.sort_order ?? 0,
    has_standings: Boolean(league.has_standings),
    meta: league.meta ? JSON.stringify(league.meta, null, 2) : '',
});

export const formatDate = (date) => {
    if (!date) {
        return '-';
    }

    const parsedDate = new Date(date);

    if (Number.isNaN(parsedDate.getTime())) {
        return '-';
    }

    return new Intl.DateTimeFormat(undefined, {
        dateStyle: 'medium',
        timeStyle: 'short',
    }).format(parsedDate);
};

export const formatNumber = (value) => {
    if (value === null || value === undefined) {
        return '0';
    }

    return new Intl.NumberFormat().format(Number(value) || 0);
};

export const getLeagueInitial = (league) => {
    return (league?.name?.trim()?.[0] || 'L').toUpperCase();
};

export const getBooleanBadge = (value, trueText, falseText, trueColor = 'success') => {
    const trueClasses = {
        success: 'bg-success bg-opacity-10 text-success',
        warning: 'bg-warning bg-opacity-10 text-warning',
        danger: 'bg-danger bg-opacity-10 text-danger',
        primary: 'bg-primary bg-opacity-10 text-primary',
    };

    return {
        text: value ? trueText : falseText,
        class: value
            ? trueClasses[trueColor] || trueClasses.success
            : 'bg-gray-100 text-muted',
    };
};
