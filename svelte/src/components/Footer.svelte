<script lang="ts">
	import Hamburger from '../icons/Hamburger.svelte';
	import { slide } from 'svelte/transition';

	let visible = false
	const toggleVisibility = () => {
		visible = !visible
	}
</script>
<nav class="{$$restProps.class || ''} w-full flex flex-col-reverse md:flex-col py-2 bg-pelorous-600 text-white">
    <div
        transition:slide
        class="{visible ? 'max-h-32' : 'max-h-0'} md:flex justify-center transition-all delay-150 duration-300 overflow-hidden md:max-h-fit">
        <div class="flex flex-col items-center md:flex-row md:gap-5">
            <a href="/">Shorten</a>
            <a href="/">Report URL</a>
            <a href="/">Terms of Use</a>
            <a href="/">Privacy Policy</a>
        </div>
    </div>
	<h2 class="my-1 w-full flex justify-center">
		<button
			class="group relative flex items-center text-left text-base transition "
			type="button" on:click={toggleVisibility}>
			<span class="mr-2 font-bold">Made with <span class="text-sm">❤</span> by 0x6D70</span>
			<span
				class="ms-auto h-5 w-5 shrink-0 md:hidden">
          <Hamburger />
        </span>
		</button>
	</h2>
</nav>
