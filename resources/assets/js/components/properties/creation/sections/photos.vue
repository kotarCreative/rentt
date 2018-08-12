<template>
    <div id="property-photos-wrapper" class="creation-section-wrapper">
        <h2>Photos</h2>
        <p>The more photos the better! Photos give your potential tenants a chance to see exactly what they will be getting for their money. It also shows them how well you have taken care of your property. Time to show off!</p>
        <div class="form-errors" v-if="hasError('data')">
            <sup>*</sup> {{ showError('data') }}
        </div>
    </div>
</template>

<script>
    import errorMixins from '../../../../mixins/errorMixins'

    export default {
        name: 'property-creation-photos',

        mixins: [ errorMixins ],

        data: () => ({
            errorModel: 'properties'
        })
    }
</script>
