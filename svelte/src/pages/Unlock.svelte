<script lang="ts">
import Card from '../components/Card.svelte';
import EyeSlash from '../icons/EyeSlash.svelte';
import Eye from '../icons/Eye.svelte';
import { querystring, replace } from 'svelte-spa-router';
import { isLoading } from '../Store';
import Services, { type CutError, type ShortenedUrl } from '../services';
import toast from 'svelte-french-toast';
import type { AxiosError } from 'axios';
let passphrase = '';
let showPassphrase = false;

const urlSearchParams = new URLSearchParams($querystring);
const urlCode = urlSearchParams.get('code');

if (!urlCode) {
    replace('/');
}

const requestUnlock = async () => {
    try {
        if (passphrase.length === 0) {
            return toast.error('Insert the password')
        }

        isLoading.set(true)
        if(!urlCode) {
            return toast.error("No url code provided");
        }
        const unlockedUrl = (await Services.unlockUrl(urlCode, passphrase)).data.result as ShortenedUrl

        if (!unlockedUrl.destination) {
                return toast.error("Missing destination, contact our support team")
        }

        window.location.href = unlockedUrl.destination ?? ''
    } catch (err: unknown) {
        if ((err as AxiosError).response?.data) {
            const errorResponse = (err as AxiosError).response?.data as CutError
            toast.error(errorResponse.message)
        } else {
            toast.error("Failed to unlock url. Check console for more details")
        }

        console.log(err)
    } finally {
        isLoading.set(false)
    }
}
const togglePassphraseShow = () => showPassphrase = !showPassphrase;
</script>

<div class="w-full h-full flex justify-center items-center flex-col flex-1">
    <Card class="w-4/5 md:w-3/5">
        <h1 class="font-black font-akshar text-bright-gray-500 text-4xl py-2 px-8 text-center">Enter the passphrase to unlock the URL</h1>
        <div class="flex w-full items-center px-2 pb-2">
            <div class="rounded-md rounded-r-none border-r-0 border-2 border-pelorous-300 flex items-center w-full bottom-0 top-0 h-10 rounded-l-md">
                <input class="pl-1 rounded-l-md w-full bottom-0 top-0 h-10 border-pelorous-300 border-2 border-x-0" {...{type: showPassphrase ? 'text' : 'password'}} bind:value={passphrase}>
                <button class="w-fit mx-1" on:click={togglePassphraseShow}>
                    {#if showPassphrase}
                        <Eye />
                    {:else}
                        <EyeSlash />
                    {/if}
                </button>
            </div>
            <button on:click={requestUnlock} class="uppercase hover:bg-pelorous-600 bg-pelorous-300 text-white font-bold px-4 py-2 h-10 rounded-r-md">UNLOCK</button>
        </div>
    </Card>
</div>
