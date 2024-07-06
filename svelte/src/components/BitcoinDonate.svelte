<script lang="ts">
import PopUp from './PopUp.svelte';
import { __env } from '../App';
</script>

<PopUp>
    <h3 class="text-center font-bold font-akshar text-bright-gray-500 text-3xl py-2 px-4">
        Make a Bitcoin donation ;)
    </h3>
    <div>
        <img src="static/bitcoin.png" class="w-96" alt="Bitcoin QrCode" />
        <div class="flex w-full items-center px-2 pb-2">
            <input value={`${__env.BTC_ADDRESS}`} class="w-full bottom-0 top-0 h-10 border-pelorous-300 border-2 border-r-0 rounded-l-md pl-1" type="text" readonly />
            <button on:click={() => navigator.clipboard.writeText(__env.BTC_ADDRESS ?? "")} class="uppercase hover:bg-pelorous-600 bg-pelorous-300 text-white font-bold px-4 py-2 h-10 rounded-r-md">Copy</button>
        </div>
    </div>
</PopUp>
