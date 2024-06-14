<script lang="ts">
	import Hamburger from '../icons/Hamburger.svelte';
	import { slide } from 'svelte/transition';

	let visible = false
	const toggleVisibility = () => {
		visible = !visible
	}
</script>

<nav class="{$$restProps.class || ''} hidden w-full justify-center gap-5 py-2 bg-pelorous-600 text-white md:flex">
	<a href="/">Shorten</a>
	<a href="/">Report URL</a>
	<p class="font-bold">Copyright © 2024 CUT. All rights reserved.</p>
	<a href="/">Terms of Use</a>
	<a href="/">Privacy Policy</a>
</nav>
<nav class="{$$restProps.class || ''} w-full flex flex-col py-2 bg-pelorous-600 text-white md:hidden">
	{#if visible}
		<div
			transition:slide
			class="transition-all delay-150 duration-300 overflow-hidden">
			<div class="flex flex-col items-center">
				<a href="/">Shorten</a>
				<a href="/">Report URL</a>
				<a href="/">Terms of Use</a>
				<a href="/">Privacy Policy</a>
			</div>
		</div>
	{/if}
	<h2 class="my-1 w-full flex justify-center">
		<button
			class="group relative flex items-center text-left text-base transition "
			type="button" on:click={toggleVisibility}>
			<span class="mr-2 font-bold">Copyright © 2024 CUT. All rights reserved.</span>
			<span
				class="ms-auto h-5 w-5 shrink-0">
          <Hamburger />
        </span>
		</button>
	</h2>
</nav>