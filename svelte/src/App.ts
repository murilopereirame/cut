import App from './App.svelte';
import type { Writable } from 'svelte/store';
import axios from 'axios';

export type {Writable}

axios.defaults.baseURL = '/api/v1/'

const app = new App({
    target: document.body
});

export default app;
