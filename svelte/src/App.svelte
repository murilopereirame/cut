<script lang="ts">
    import "./App.css"
    import Home from './pages/Home.svelte';
    import Result from './pages/Result.svelte';
    import Router from 'svelte-spa-router';
		import { Toaster } from 'svelte-french-toast';

    const routes = {
        '/': Home,
        '/result': Result,
    }
</script>

<Router {routes}/>
<Toaster />