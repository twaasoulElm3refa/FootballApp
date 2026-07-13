import { useToast } from 'vue-toastification';

let toastInstance = null;

const getToast = () => {
    if (!toastInstance) {
        toastInstance = useToast();
    }

    return toastInstance;
};

export const toastSuccess = (message = 'Operation completed successfully') => {
    getToast().success(message);
};

export const toastError = (message = 'Something went wrong') => {
    getToast().error(message);
};

export const toastInfo = (message = 'Processing request') => {
    getToast().info(message);
};

export const toastWarning = (message = 'Please check your input') => {
    getToast().warning(message);
};
