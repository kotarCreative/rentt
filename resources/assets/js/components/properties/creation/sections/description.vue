<template>
    <div id="property-address-wrapper" class="creation-section-wrapper">
        <h2>Description</h2>
        <div class="form-group">
            <label for="title">Listing Title<sup v-if="hasError('title')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                :class="{ 'has-error': hasError('title') }"
                name="title"
                type="text"
                v-model="property.title"
                placeholder="Anything"
                @input="removeError('title', $event)">
        </div>
        <div class="form-group">
            <label for="available_at">When is the suite available?<sup v-if="hasError('available_at')" class="form-errors">*</sup></label>
            <datepicker
                class="datepicker"
                :class="{ 'has-error': hasError('available_at') }"
                format="MMM d, yyyy"
                placeholder="Any time"
                v-model="property.available_at"
                :disabled="{ to: new Date() }"
                @input="removeError('available_at', $event)">
            </datepicker>
        </div>
        <div class="form-group">
            <label for="price">Price<sup v-if="hasError('price')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                :class="{ 'has-error': hasError('price') }"
                name="price"
                type="text"
                v-model="property.price"
                placeholder="Any"
                @input="removeError('price', $event)">
        </div>
        <div class="form-group">
            <label for="deposit">Damage Deposit<sup v-if="hasError('damage_deposit')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                :class="{ 'has-error': hasError('damage_deposit') }"
                name="deposit"
                type="text"
                v-model="property.damage_deposit"
                placeholder="Any"
                @input="removeError('damage_deposit', $event)">
        </div>
        <div class="form-group">
            <label for="description">Description<sup v-if="hasError('description')" class="form-errors">*</sup></label>
            <div class="text-area">
                <textarea
                    class="form-control"
                    :class="{ 'has-error': hasError('description') }"
                    v-model="property.description"
                    maxlength="500"
                    placeholder="Write your description here..."
                    @input="removeError('description', $event)"></textarea>
                <span class="word-count">{{ property.description ? 500 - property.description.length : 500 }}</span>
            </div>
        </div>
        <div class="form-errors" v-if="hasError('data')">
            <sup>*</sup> {{ showError('data') }}
        </div>
        <div class="form-errors" v-else-if="hasErrors()">
            <sup>*</sup>Please Complete Required Fields
        </div>
    </div>
</template>

<script>
    import Datepicker from "vuejs-datepicker"
    import errorMixins from '../../../../mixins/errorMixins'

    export default {
        name: 'property-creation-description',

        mixins: [ errorMixins ],

        components: {
            Datepicker
        },

        data: () => ({
            errorModel: 'properties'
        }),

        computed: {
            property() {
                return this.$store.getters['properties/active'];
            }
        }
    }
</script>
