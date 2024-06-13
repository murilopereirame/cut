<script lang="typescript">
    import {BootstrapToast, ToastContainer} from "svelte-toasts";
</script>

<h1>Hello!</h1>
<ToastContainer placement="bottom-left" let:data={data}>
    <BootstrapToast {data}/>
</ToastContainer>