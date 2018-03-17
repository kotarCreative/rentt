<template>
    <div id="single-property-page">
        <div class="row full-height">
            <div class="sm-1-2">
                <div class="listing-header">
                    <h1>{{ property.title }}</h1>
                    <h4>{{ property.location }}</h4>
                </div>
            </div>
            <div class="sm-1-2"></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'single-property-page',

        props: {
            property: {
                type: Object,
                required: true
            }
        }
    }
</script>