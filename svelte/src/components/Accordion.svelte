<script lang="ts">
	import { slide } from 'svelte/transition';

	export let rotate = true
	let visible = false
	const toggleVisibility = () => {
		visible = !visible
	}
</script>
<div
	class="w-fit {$$restProps.class || ''}">
	<h2 class="mb-0">
		<button
			class="group relative flex items-center text-left text-base transition "
			type="button" on:click={toggleVisibility}>
			<slot name="title" />
			<span
				class="-me-1 ms-auto h-5 w-5 shrink-0 {visible && rotate ? 'rotate-[-180deg]' : ''} transition-transform duration-200 ease-in-out">
          <slot name="icon" />
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