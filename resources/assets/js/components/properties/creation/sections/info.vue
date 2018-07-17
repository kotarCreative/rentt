<template>
    <div id="property-info-wrapper" class="creation-section-wrapper">
        <h2>Basic Info</h2>
        <div class="form-group">
            <label for="type">Home Type<sup v-if="hasError('type_id')" class="form-errors">*</sup></label>
            <v-select class="form-control single"
                      :class="{ 'has-error': hasError('type_id') }"
                      name="type_id"
                      v-model="propertyType"
                      :clearable="false"
                      :searchable="false"
                      @input="removeError('type_id', $event)"
                      :options="propertyTypes"
                      label="name"
                      placeholder="Any">
            </v-select>
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
            <v-select class="form-control single"
                      :class="{ 'has-error': hasError('bedrooms') }"
                      name="bedrooms"
                      v-model="bedrooms"
                      :clearable="false"
                      :searchable="false"
                      @input="removeError('bedrooms', $event)"
                      :options="bedroomOptions"
                      placeholder="Any">
            </v-select>
        </div>
        <div class="form-group">
            <label for="bathrooms">Bathrooms<sup v-if="hasError('bathrooms')" class="form-errors">*</sup></label>
            <v-select class="form-control single"
                      :class="{ 'has-error': hasError('bathrooms') }"
                      name="bathrooms"
                      v-model="bathrooms"
                      :clearable="false"
                      :searchable="false"
                      @input="removeError('bathrooms', $event)"
                      :options="bathroomOptions"
                      placeholder="Any">
            </v-select>
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
            bathroomOptions: [
                {
                    label: '1',
                    value: '1',
                },
                {
                    label: '2',
                    value: '2',
                },
                {
                    label: '3+',
                    value: '3',
                }
            ],
            bedroomOptions: [
                {
                    label: 'Studio',
                    value: '0',
                },
                {
                    label: '1',
                    value: '1',
                },
                {
                    label: '2',
                    value: '2',
                },
                {
                    label: '3',
                    value: '3',
                },
                {
                    label: '4+',
                    value: '4',
                }
            ],
            errorModel: 'properties'
        }),

        mounted() {
            this.$store.dispatch('properties/details');
        },

        computed: {
            bathrooms: {
                get() {
                    var option = this.bathroomOptions.find(o => o.value == this.property.bathrooms);
                    return option;
                },
                set(val) {
                    this.$store.commit('properties/updateActive', { key: 'bathrooms', val: val ? val.value : null });
                }
            },

            bedrooms: {
                get() {
                    var option = this.bedroomOptions.find(o => o.value == this.property.bedrooms);
                    return option;
                },
                set(val) {
                    this.$store.commit('properties/updateActive', { key: 'bedrooms', val: val ? val.value : null });
                }
            },

            property() {
                return this.$store.getters['properties/active'];
            },

            propertyType: {
                get() {
                    var option = this.propertyTypes.find(o => o.id == this.property.type_id);
                    return option;
                },
                set(val) {
                    this.$store.commit('properties/updateActive', { key: 'type_id', val: val.id });
                }
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
