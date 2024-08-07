<script lang="ts">
import Card from '../components/Card.svelte';
import Feature from '../components/Feature.svelte';
import QrCode from "../../static/qr-code.svg"
import PasswordProtected from "../../static/password-protected.svg"
import NoPersonalData from "../../static/personal-data.svg"
import Accordion from '../components/Accordion.svelte';
import Eye from '../icons/Eye.svelte';
import EyeSlash from '../icons/EyeSlash.svelte';
import { slide } from 'svelte/transition';
import { push } from 'svelte-spa-router';
import { isLoading, isProtected, originalUrl, shortenedUrl } from '../Store';
import Services, { type CutError, type ShortenedUrl } from '../services';
import toast from 'svelte-french-toast';
import type { AxiosError } from 'axios';
import BuyMeaCoffee from '../../static/bmc-button.svg'
import { Popup } from '../components/PopUp.svelte';
import Footer from '../components/Footer.svelte';
import BitcoinDonate from '../components/BitcoinDonate.svelte';

interface FeatureItem {
	title: string;
	image: string;
	text: string
}



let protect = false
let showPassword = false
let url = ''
let password = ''

const togglePasswordShow = () => {
	showPassword = !showPassword
}

const shortenUrl = async () => {
    if (url.length === 0) {
        return toast.error('Insert the url to be shortened')
    } else if (protect && password.length === 0) {
        return toast.error('Insert the password to protect the URL or disable password protection')
    }

    try {
        isLoading.set(true)
        const shortenedUrlData = (await Services.shortenUrl(
            url,
            password.length > 0 ? password : undefined
        )).data.result as ShortenedUrl

        originalUrl.set(url)
        shortenedUrl.set(shortenedUrlData.full_url)
        isProtected.set(shortenedUrlData.encrypted)

        return push('/result')
    } catch (err: unknown) {
        if ((err as AxiosError).response?.data) {
            const errorResponse = (err as AxiosError).response?.data as CutError
            toast.error(errorResponse.message)
        } else {
            toast.error("Failed to shorten url. Check console for more info")
        }
        console.log(err)
    } finally {
        isLoading.set(false)
    }
}

const features: FeatureItem[] = [{
	title: "Shorten, Scan and go!",
	text: "Every shortened URL generate a corresponding QR Code",
	image: QrCode
}, {
	title: "Password Protection",
	text: "Encrypt shortened URLs and protect them with a password",
	image: PasswordProtected
}, {
	title: "No tracking data",
	text: "No data is collected! Stay free of UTMs and tracking tags*",
	image: NoPersonalData
}]
</script>
<div class="w-full h-full flex justify-center items-center flex-col my-4 flex-1">
	<Card class="w-4/5 md:w-3/5">
		<h1 class="text-2xl font-black font-akshar text-bright-gray-500 py-2 px-8 text-center md:text-4xl">Enter a URL and start shortening!</h1>
		<div class="flex w-full items-center px-2 pb-2">
			<input bind:value={url} class="w-full bottom-0 top-0 h-10 border-pelorous-300 border-2 border-r-0 rounded-l-md pl-1" type="url" />
			<button on:click={shortenUrl} class="uppercase hover:bg-pelorous-600 bg-pelorous-300 text-white font-bold px-4 py-2 h-10 rounded-r-md">Shorten</button>
		</div>
        <div class="flex justify-between flex-col md:flex-row">
            <Accordion class="w-1/3 ml-2">
                <svg
                    slot="icon"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>

                <h2 slot="title" class="font-bold mr-2">Options</h2>
                <label><input type="checkbox" bind:checked={protect}/> Enable password protection</label>

                {#if protect}
                    <div transition:slide class="rounded-md border-2 border-pelorous-300 w-fit flex items-center">
                        <input  {...{ type: showPassword ? 'text' : 'password' }} bind:value={password} class="rounded-l-md pl-1">
                        <button class="w-fit mx-1" on:click={togglePasswordShow}>
                            {#if showPassword}
                                <Eye />
                            {:else}
                                <EyeSlash />
                            {/if}
                        </button>
                    </div>
                {/if}
            </Accordion>
            <div class="flex items-center justify-end mt-4 md:mt-0 mr-2">
                <a target="_blank" href="https://buymeacoffee.com/0x6d70" rel="noopener noreferrer nofollow">
                    <img class="w-24" src={BuyMeaCoffee} alt="Buy me a Coffee" />
                </a>
                <button class="ml-1" on:click={Popup.show}>
                    <img class="w-[5.5rem]" src="https://img.shields.io/badge/Donate-FF9900?logo=bitcoin&logoColor=white" alt="Donate with Bitcoin" />
                </button>
            </div>
        </div>
	</Card>
	<Card class="w-4/5 md:w-3/5 mt-4 py-8">
		<div class="grid gap-10 px-2 grid-cols-1 md:grid-cols-3">
			{#each features as feature}
				<Feature title={feature.title} image={feature.image} text={feature.text} />
			{/each}
		</div>
	</Card>
	<div class="w-4/5 md:w-3/5 mt-2">
		<p class="text-xs text-left">* UTMs present in the original URL are preserved. No new tracking tag is generated by us</p>
	</div>
</div>
<BitcoinDonate />
