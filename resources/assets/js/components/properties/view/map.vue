<template>
    <gmap-map
        :center="mapCenter"
        style="width: 100%; height: 100%;"
        :zoom="15"
        class="property-listings-map"
      >
        <gmap-marker v-for="property in properties"
                     :key="property.id"
                    :position="property.coordinates"
        ></gmap-marker>
      </gmap-map>
</template>

<script>
    export default {
        name: 'properties-map',

        props: {
            properties: {
                type: Array,
                required: true
            }
        },

        computed: {
            mapCenter() { return { lat: 53.5444, lng: -113.4909 } }
        }
    }
</script>
