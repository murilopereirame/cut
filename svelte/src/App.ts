import App from './App.svelte';
import type { Writable } from 'svelte/store';
import axios from 'axios';

axios.defaults.baseURL = '/api/v1/'

const app = new App({
    target: document.body
});

const {env: __env} = process
export type {Writable}

export {__env}
export default app;
