<script lang="ts">
    import Card from '../components/Card.svelte';
    import Services, { type CutError, type Takedown } from '../services';
    import Badge from '../components/Badge.svelte';
    import toast from 'svelte-french-toast';
    import { isLoading } from '../Store';
    import type { AxiosError } from 'axios';
    import { __env } from '../App';

    let reports: Takedown[] = [];

    const loadReports = async () => {
        try {
            isLoading.set(true);
            let reportsRequest = await Services.listReports();
            reports = reportsRequest.data.result as Takedown[];
        } catch (err: unknown) {
            if ((err as AxiosError).response?.data) {
                const errorResponse = (err as AxiosError).response?.data as CutError;
                toast.error(errorResponse.message);
            } else {
                toast.error('Failed to list reports. Check console for more details');
            }

            console.log(err);
        } finally {
            isLoading.set(false);
        }
    };

    loadReports();
</script>
<div class="w-full h-full flex justify-center items-center flex-col flex-1">
    <Card class="w-4/5 md:w-3/5 my-12">
        <h1 class="text-center font-black font-akshar text-bright-gray-500 text-4xl py-2">Reported URLs</h1>
        <table
            class="bg-pelorous-600 bg-opacity-5 pb-4 table-auto text-sm text-center font-light w-full border border-separate border-spacing-0 border-tools-table-outline border-pelorous-600 border-opacity-30 border-1 rounded-md">
            <thead>
            <tr>
                <th class="border-b text-center font-medium text-slate-400 p-4">URL</th>
                <th class="border-b font-medium text-slate-400 p-4 text-center">Reason</th>
                <th class="border-b font-medium text-slate-400 p-4 text-center">Status</th>
            </tr>
            </thead>
            <tbody class="bg-white dark:bg-slate-800">
            {#each reports as report}
                <tr>
                    <td class="border-b border-r border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                        <a class="underline" target="_blank" href="{__env.SHORTENED_BASE_URL}/{report.url_id}" rel="noreferrer nofollow noopener">
                            {__env.SHORTENED_BASE_URL}/{report.url_id}
                        </a></td>
                    <td class="border-b border-r border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                        <p>{report.reason}</p></td>
                    <td class="border-b border-r border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                        <Badge variant={report.status} />
                    </td>
                </tr>
            {/each}
            </tbody>
        </table>
    </Card>
</div>
