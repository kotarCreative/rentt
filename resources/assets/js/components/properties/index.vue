<template>
    <div id="property-listings">
        <div class="row">
            <div class="xs-1-1 sm-2-3">
                <listings style="grid"></listings>
            </div>
            <div class="xs-1-1 sm-1-3">
                <map></map>
            </div>
        </div>
    </div>
</template>

<script>
    import Listings from './listings';
    import Map from './map';

    export default {
        name: 'properties-page',

        components: {
            Listings,
            Map
        }
    }
</script>
