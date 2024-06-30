<script lang="ts">
    import "./App.css"
    import Home from './pages/Home.svelte';
    import Result from './pages/Result.svelte';
    import Router from 'svelte-spa-router';
		import { Toaster } from 'svelte-french-toast';
		import Footer from './components/Footer.svelte';
    import Unlock from './pages/Unlock.svelte';
    import LoadingOverlay from './components/LoadingOverlay.svelte';
    import Terms from './pages/Terms.svelte';
    import Privacy from './pages/Privacy.svelte';
    import Report from './pages/Report.svelte';
    import ReportList from './pages/ReportList.svelte';

    const routes = {
        '/': Home,
        '/result': Result,
        '/unlock': Unlock,
        '/terms-of-service': Terms,
        '/privacy-policy': Privacy,
        '/report': Report,
        '/reports': ReportList
    }
</script>

<div class="flex flex-col relative h-full min-h-[100vh] justify-center">
	<Router {routes}/>
	<Toaster />
	<Footer class="justify-self-end flex bottom-0" />
</div>
<LoadingOverlay />
