import { writable } from 'svelte/store';
import type {Writable} from "./App"
export const shortenedUrl: Writable<string | undefined> = writable(undefined)
export const originalUrl: Writable<string | undefined> = writable(undefined)
export const isProtected: Writable<boolean> = writable(false)
export const isLoading: Writable<boolean> = writable(false)
