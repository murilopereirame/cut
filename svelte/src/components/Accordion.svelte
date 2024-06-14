<script lang="ts">
	import { slide } from 'svelte/transition';

	let visible = false
	const toggleVisibility = () => {
		visible = !visible
	}
</script>
<div
	class="w-fit {$$restProps.class || ''}">
	<h2 class="mb-0">
		<button
			class="group relative flex items-center bg-white text-left text-base transition "
			type="button" on:click={toggleVisibility}>
			<slot name="title" />
			<span
				class="-me-1 ms-auto h-5 w-5 shrink-0 {visible ? 'rotate-[-180deg]' : ''} transition-transform duration-200 ease-in-out">
          <svg
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
        </span>
		</button>
	</h2>
	{#if visible}
		<div
			transition:slide
			class="transition-all delay-150 duration-300 overflow-hidden">
			<slot />
		</div>
	{/if}
</div>