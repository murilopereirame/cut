import App from './App.svelte';
import type { Writable } from 'svelte/store';

export type {Writable}

const app = new App({
    target: document.body
});

export default app;