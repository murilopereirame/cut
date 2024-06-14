<script lang="ts">
	export let image: string = ""
	export let title: string =""
	export let text: string = ""
</script>

<div class="flex flex-col items-center">
	<img class="w-56 h-56" src={image} alt={title} />
	<h2 class="text-lg font-bold text-pelorous-500 text-center">{title}</h2>
	<p class="text-center text-sm">{@html text}</p>
</div>