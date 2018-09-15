<template>
    <div class="property-form">
        <div class="property-form-header">
            {{ idx + 1}}.
            <div class="text-btn" @click="removeProperty">&times;</div>
        </div>
        <div class="row marginless">
            <div class="sm-1-2">
                <div class="form-group">
                    <label for="started-on">Moved In<sup v-if="hasError(errorStart + '.started_on')" class="form-errors">*</sup></label>
                    <datepicker
                        class="datepicker full-width"
                        format="MMM d, yyyy"
                        placeholder="Any time"
                        v-model="property.started_on"
                        @input="removeError(errorStart + '.started_on', $event)">
                    </datepicker>
                </div>
            </div>
            <div class="sm-1-2">
                <div class="form-group">
                    <label for="ended-on">Moved Out<sup v-if="hasError(errorStart + '.ended_on')" class="form-errors">*</sup></label>
                    <datepicker
                        class="datepicker full-width"
                        format="MMM d, yyyy"
                        placeholder="Any time"
                        v-model="property.ended_on"
                        @input="removeError(errorStart + '.ended_on', $event)">
                    </datepicker>
                </div>
            </div>
        </div>
        <div class="row marginless">
            <div class="sm-1-1">
                <div class="form-group">
                    <label for="location">Location<sup v-if="hasError(errorStart + '.location')" class="form-errors">*</sup></label>
                    <input
                        class="form-control full-width"
                        type="text"
                        name="location"
                        placeholder="ie. Edmonton"
                        v-model="property.location"
                        @input="removeError(errorStart + '.location', $event)"
                    />
                </div>
            </div>
        </div>
        <div class="row marginless">
            <div class="sm-1-1">
                <h4>Landlords Details</h4>
            </div>
        </div>
        <div class="row marginless">
            <div class="sm-1-2">
                <div class="form-group">
                    <label for="landlord-first-name">First Name<sup v-if="hasError(errorStart + '.landlord_first_name')" class="form-errors">*</sup></label>
                    <input
                        class="form-control full-width"
                        type="text"
                        name="landlord-first-name"
                        placeholder="ie. Bram"
                        v-model="property.landlord_first_name"
                        @input="removeError(errorStart + '.landlord_first_name', $event)"
                    />
                </div>
            </div>
            <div class="sm-1-2">
                <div class="form-group">
                    <label for="landlord-last-name">Last Name<sup v-if="hasError(errorStart + '.landlord_last_name')" class="form-errors">*</sup></label>
                    <input
                        class="form-control full-width"
                        type="text"
                        name="landlord-last-name"
                        placeholder="ie. Stoker"
                        v-model="property.landlord_last_name"
                        @input="removeError(errorStart + '.landlord_last_name', $event)"
                    />
                </div>
            </div>
        </div>
        <div class="row marginless">
            <div class="sm-1-1">
                <div class="form-group">
                    <label for="landlord-email">Email<sup v-if="hasError(errorStart + '.landlord_email')" class="form-errors">*</sup></label>
                    <input
                        class="form-control full-width"
                        type="text"
                        name="landlord-email"
                        placeholder="ie. dracula@thecount.com"
                        v-model="property.landlord_email"
                        :disabled="property.id"
                        @input="removeError(errorStart + '.landlord_email', $event)"
                    />
                </div>
            </div>
        </div>
        <div class="form-errors" v-if="errorExists()">
            <sup>*</sup>Please Complete Required Fields
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import ErrorMixins from '../../../../../mixins/errorMixins';

    export default {
        name: 'property-form',

        mixins: [ ErrorMixins ],

        components: {
            Datepicker
        },

        props: {
            idx: {
                type: Number,
                required: true
            },

            property: {
                required: true
            }
        },

        data: () => ({
            errorModel: 'users'
        }),

        computed: {
            errorStart() { return 'rental_history.' + this.idx }
        },

        methods: {
            errorExists() {
                return this.hasError(this.errorStart + '.started_on') ||
                    this.hasError(this.errorStart + '.ended_on') ||
                    this.hasError(this.errorStart + '.landlord_first_name') ||
                    this.hasError(this.errorStart + '.landlord_last_name') ||
                    this.hasError(this.errorStart + '.landlord_email');
            },

            removeProperty() {
                this.$store.commit('users/removeProperty', this.idx);
            }
        }
    }
</script>
