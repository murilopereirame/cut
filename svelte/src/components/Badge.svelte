<script lang="ts">

    import { TakedownStatus } from '../services';

    export let variant: TakedownStatus = TakedownStatus.PENDING;

    const getBadgeColors = () => {
        switch (variant) {
            default:
                return "bg-blue-100 text-blue-800 dark:bg-gray-700 dark:text-blue-300 border-blue-300"
            case TakedownStatus.REJECTED:
                return "bg-green-100 text-green-800 dark:bg-gray-700 dark:text-green-300 border-green-300"
            case TakedownStatus.ACCEPTED:
                return "bg-red-100 text-red-800 dark:bg-gray-700 dark:text-red-300 border-red-300"
            case TakedownStatus.PROCESSING:
                return "bg-yellow-100 text-yellow-800 dark:bg-gray-700 dark:text-yellow-300 border-yellow-300"
        }
    }

    const getBadgeText = () => {
        switch (variant) {
            case TakedownStatus.ACCEPTED:
                return "Removed"
            case TakedownStatus.REJECTED:
                return "Maintained"
            case TakedownStatus.PROCESSING:
                return "Processing"
            default:
                return "Pending"
        }
    }
</script>
<span class="text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 border border-blue-400 {getBadgeColors()}">
    {getBadgeText()}
</span>
