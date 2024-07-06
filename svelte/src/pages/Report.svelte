    <script lang="ts">
import Card from '../components/Card.svelte';
import toast from 'svelte-french-toast';
import { isLoading } from '../Store';
import Services, { type CutError } from '../services';
import type { AxiosError } from 'axios';

import {link} from 'svelte-spa-router'
import active from 'svelte-spa-router/active'

let reason = ''
let passphrase = ''
let url = ''

const requestTakedown = async () => {
    try {
        if (url.length === 0) {
            return toast.error('Insert the url code')
        } else if (reason.length === 0) {
            return toast.error('Insert the reason of your request')
        }

        isLoading.set(true)
        await Services.reportUrl(url, reason, passphrase.length === 0 ? undefined : passphrase)

        reason = ''
        passphrase = ''
        url = ''

        return toast.success(`Report created for URL ${url}`)
    } catch (err: unknown) {
        if ((err as AxiosError).response?.data) {
            const errorResponse = (err as AxiosError).response?.data as CutError
            toast.error(errorResponse.message)
        } else {
            toast.error("Failed to save report. Check console for more details")
        }

        console.log(err)
    } finally {
        isLoading.set(false)
    }
}
</script>

<div class="w-full h-full flex justify-center items-center flex-col flex-1 my-20">
    <Card class="w-4/5 md:w-3/5 px-4">
        <h1 class="text-center font-black font-akshar text-bright-gray-500 text-4xl py-2">Report URL</h1>
        <div class="flex flex-col mt-2 text-pelorous-500 font-akshar">
            <label for="url">URL Code*</label>
            <input bind:value={url} class="border-2 border-pelorous-300 rounded-md pl-1" type="url" id="url" />
        </div>
        <div class="flex flex-col mt-2 text-pelorous-500 font-akshar">
            <label for="password">Password¹</label>
            <input bind:value={passphrase} class="border-2 border-pelorous-300 rounded-md pl-1" type="password" id="password" />
        </div>
        <div class="flex flex-col mt-2 text-pelorous-500 font-akshar">
            <label for="reason">Reason*</label>
            <textarea bind:value={reason} class="border-2 border-pelorous-300 rounded-md px-1" id="reason" maxlength="300"></textarea>
            <span class="text-sm text-start">{reason.length} of 300</span>
        </div>
        <div class="flex justify-end items-center mb-2">
            <button on:click={requestTakedown} class="bg-pelorous-500 hover:bg-pelorous-500 text-white py-2 px-4 rounded-md">Submit</button>
        </div>
    </Card>
    <div class="w-4/5 md:w-3/5 mt-2">
        <p class="text-xs text-left">
            * Fields with this mark are required
        </p>
        <p class="text-xs text-left">
            ** You can check reported URLs and their status <a class="text-pelorous-500 underline" href="/reports" use:link use:active>here</a>
        </p>
        <p class="text-xs text-left">
            ¹ We ask for the password to check the content of encrypted URLs before taking any action.<br/>
            After our analysis the password will be removed from our database
        </p>
    </div>
</div>
