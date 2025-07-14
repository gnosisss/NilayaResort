import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Import Flatpickr for date picking
import flatpickr from 'flatpickr';
window.flatpickr = flatpickr;
