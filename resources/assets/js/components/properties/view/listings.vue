<template>
    <div id="property-listings">
        <sub-filters></sub-filters>
    </div>
</template>

<script>
    import SubFilters from './sub-filters';
    export default {
        name: 'property-listings',

        components: {
            SubFilters
        }
    }
</script>
