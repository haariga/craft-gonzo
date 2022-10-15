import axios from 'axios';

export const api = axios.create({
  baseURL: window.$gonzo.baseUrl,
  headers: {
    'X-CSRF-Token': window.$gonzo.csrfToken.value,
  },
});
