<script lang="ts">
    import Spinner from './Spinner.svelte';
    import { isLoading } from '../Store';
    import { onDestroy } from 'svelte';
    let showLoading = false

    const unsubscribe = isLoading.subscribe((isLoading) => {console.log("Is loading: ", isLoading); showLoading = isLoading})
    onDestroy(() => unsubscribe())
</script>

<div class="{showLoading ? 'fixed' : 'hidden'} w-screen h-screen bg-white bg-opacity-80 flex flex-col justify-center items-center">
    <Spinner class="w-16 h-16 border-8" />
</div>
