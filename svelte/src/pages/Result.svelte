<script lang="ts">
	import { replace } from 'svelte-spa-router';
	import { shortenedUrl, originalUrl, isProtected } from '../Store';
	import Card from '../components/Card.svelte';
	import toast from 'svelte-french-toast';
	import QRCode from "qrcode"
    import Spinner from '../components/Spinner.svelte';
	let url: string = ""
	let ogUrl: string = ""
	let diff: number = 0
	let isTheUrlProtected: boolean = false
	let qrCodePng: string | undefined = undefined

	const checkUrl = () => {
		if (!$shortenedUrl || !$originalUrl) {
			return replace('/')
		}

		url = $shortenedUrl
		ogUrl = $originalUrl
		diff = ($originalUrl?.length ?? 0) - $shortenedUrl.length
		isTheUrlProtected = $isProtected

		shortenedUrl.set(undefined)
		originalUrl.set(undefined)
		isProtected.set(false)
	}

	const copyToClipboard = () => {
		navigator.clipboard.writeText(url)
		toast.success('Copied to clipboard')
	}

	const generateQrCode = async () => {
		await new Promise((resolve) => setTimeout(() => resolve(true), 5000))
		qrCodePng = await QRCode.toDataURL(url, {
			type: "image/png",
			margin: 0,
			scale: 8
		})
	}

	checkUrl()
	generateQrCode()
</script>

<div class="w-full h-full flex justify-center items-center flex-col flex-1">
	<Card class="max-w-2xl w-4/5 md:w-3/5">
		<h1 class="font-black font-akshar text-bright-gray-500 text-4xl py-2 px-8 text-center">URL Shortened!</h1>
		<div class="flex w-full items-center px-2 pb-2">
			<input readonly value={url} class="w-full bottom-0 top-0 h-10 border-pelorous-300 rounded-l-md border-2 border-r-0 pl-1" type="url" />
			<button on:click={copyToClipboard} class="uppercase hover:bg-pelorous-600 bg-pelorous-300 text-white font-bold px-4 py-2 h-10 rounded-r-md">Copy</button>
		</div>
		<div class="flex w-full pb-2 px-2 flex-col md:flex-row">
			<div class="min-w-48 min-h-56 flex flex-col items-center justify-center mt-2 md:mt-0">
				{#if qrCodePng}
					<img class="w-full" src={qrCodePng} alt="QR Code" />
					<a href={qrCodePng} download="qrcode.png" class="text-center mt-2 bg-pelorous-300 w-full rounded-md text-white">Download PNG</a>
				{:else}
					<Spinner />
					<span class="text-pelorous-500 mt-2">Loading...</span>
				{/if}
			</div>
			<div class="flex flex-col mt-2 md:ml-2 md:mt-0 min-w-0">
				<div>
					<h3 class="text-xl font-bold">Original URL</h3>
					<a class="break-words whitespace-pre-wrap underline text-pelorous-500" href={ogUrl} target="_blank" rel="noopener noreferrer">{ogUrl}</a>
					<h3 class="text-lg font-bold mt-2">Length Difference</h3>
					<span>{diff} characters {diff > 0 ? "shortener" : "bigger"}</span>
					<h3 class="text-lg font-bold mt-2">Password protected</h3>
					<span>{isTheUrlProtected ? "Yes" : "No"}</span>
				</div>
			</div>
		</div>
	</Card>
</div>
