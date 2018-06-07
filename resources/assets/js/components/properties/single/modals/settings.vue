<template>
    <vue-modal name="property-settings" :on-close="closeModal">
        <h2 slot="header">Update Property Details</h2>
        <div class="form-group">
            <v-checkbox v-model="property.is_active"
                        name="active"
                        type="checkbox">
                <span slot="label">Active <span class="desc">The property will be shown in the search</span></span>
            </v-checkbox>
        </div>
        <div class="form-group">
            <v-checkbox v-model="property.is_occupied"
                        name="occupied"
                        type="checkbox">
                <span slot="label">Occupied <span class="desc">Removes the property from the search</span></span>
            </v-checkbox>
        </div>
        <div class="form-errors" v-if="hasErrors()">
            <sup>*</sup>The property must be completed before it can be set to active or occupied.
        </div>
        <div class="modal-actions">
            <button class="listing-btn" @click="destroy">Delete Listing</button>
            <button class="btn" @click="save">Save</button>
        </div>
    </vue-modal>
</template>

<script>
    import ErrorMixins from '../../../../mixins/errorMixins';

    export default {
        name: 'single-property-settings-modal',

        mixins: [ErrorMixins],

        data: _ => ({
            errorModel: 'properties'
        }),

        computed: {
            property() {
                return this.$store.getters['properties/active'];
            }
        },

        methods: {
            closeModal() {
                this.$store.commit('properties/resetActive');
                this.$store.commit('clearErrors', 'properties');
            },

            destroy() {
                this.$store.dispatch('properties/destroy');
            },

            save() {
                this.$store.dispatch('properties/update');
            }
        }
    }
</script>
