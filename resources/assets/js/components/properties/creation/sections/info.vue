<template>
    <div id="property-info-wrapper" class="creation-section-wrapper">
        <h2>Basic Info</h2>
        <div class="form-group">
            <label for="type">Home Type<sup v-if="hasError('type_id')" class="form-errors">*</sup></label>
            <select
                class="form-control"
                :class="{ 'has-error': hasError('type_id') }"
                name="type"
                v-model="property.type_id"
                @input="removeError('type_id', $event)">
                <option :value="null" disabled>Any</option>
                <option v-for="type in propertyTypes" :value="type.id">
                    <i class="icon bedrooms" :class="type.icon" aria-hidden="true"></i>{{ type.name }}
                </option>
            </select>
        </div>
        <div class="form-group">
            <label for="size">Size (sq.ft.)<sup v-if="hasError('size')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                :class="{ 'has-error': hasError('size') }"
                name="size"
                type="text"
                v-model="property.size"
                placeholder="Any"
                @keypress="isNumber($event)"
                @input="removeError('size', $event)">
        </div>
        <div class="form-group">
            <label for="bedrooms">Bedrooms<sup v-if="hasError('bedrooms')" class="form-errors">*</sup></label>
            <select
                class="form-control"
                :class="{ 'has-error': hasError('bedrooms') }"
                name="bedrooms"
                v-model="property.bedrooms"
                @input="removeError('bedrooms', $event)">
                <option :value="null" disabled>Any</option>
                <option value="0">Studio</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4+</option>
            </select>
        </div>
        <div class="form-group">
            <label for="bathrooms">Bathrooms<sup v-if="hasError('bathrooms')" class="form-errors">*</sup></label>
            <select
                class="form-control"
                :class="{ 'has-error': hasError('bathrooms') }"
                name="bathrooms"
                v-model="property.bathrooms"
                @input="removeError('bathrooms', $event)">
                <option :value="null" disabled>Any</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3+</option>
            </select>
        </div>
        <div class="form-errors" v-if="hasErrors()">
            <sup>*</sup>Please Complete Required Fields
        </div>
    </div>
</template>

<script>
    import errorMixins from '../../../../mixins/errorMixins';

    export default {
        name: 'property-creation-info',

        mixins: [ errorMixins ],

        data: () => ({
            errorModel: 'properties'
        }),

        mounted() {
            this.$store.dispatch('properties/details');
        },

        computed: {
            property() {
                return this.$store.getters['properties/active'];
            },

            propertyTypes() {
                return this.$store.getters['properties/types'];
            }
        },

        methods: {
            isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();;
                } else {
                    return true;
                }
            }
        }
    }
</script>
