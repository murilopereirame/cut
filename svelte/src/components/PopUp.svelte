<script lang="ts">
import Card from './Card.svelte';
import { onDestroy, onMount } from 'svelte';
import Close from '../icons/Close.svelte';

const togglePopUp = (e: KeyboardEvent) => e.code === "Escape" && $isShown ? Popup.hide() : null
onMount(() => document.addEventListener('keydown', togglePopUp))
onDestroy(() => document.removeEventListener('keydown', togglePopUp))
</script>

<script lang="ts" context="module">
import { type Writable, writable } from 'svelte/store';
const isShown: Writable<boolean> = writable(false)

const Popup = {
    show: () => isShown.set(true),
    hide: () => isShown.set(false),
}
export {Popup}
</script>

<div role="tabpanel" tabindex="0" on:keydown={(e) => e.code === "Enter" ? Popup.hide() : null} class="{!$isShown ? 'hidden' : ''} bg-white bg-opacity-70 z-10 w-full h-full absolute" on:click={Popup.hide}></div>
<div class="fixed z-20 max-w-[90%] top-1/4 left-0 right-0 my-0 mx-auto w-fit opacity-100 {!$isShown ? 'opacity-0 transform -translate-y-[120vh]' : ''} transition-transform duration-[350ms] md:top-auto">
    <button on:click="{Popup.hide}" class="z-50 -right-3 -top-3 absolute"><Close /></button>
    <Card class="h-fit">
        <slot />
    </Card>
</div>
