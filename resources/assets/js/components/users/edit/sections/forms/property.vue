<template>
    <div class="property-form">
        <div class="property-form-header">
            {{ idx + 1}}.
            <div class="text-btn" @click="removeProperty">remove</div>
        </div>
        <div class="row">
            <div class="sm-1-2">
                <div class="form-group">
                    <label for="started-on">Moved In<sup v-if="hasError(errorStart + '.started_on')" class="form-errors">*</sup></label>
                    <datepicker
                        class="datepicker"
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
                        class="datepicker"
                        format="MMM d, yyyy"
                        placeholder="Any time"
                        v-model="property.ended_on"
                        @input="removeError(errorStart + '.ended_on', $event)">
                    </datepicker>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="sm-1-2">
                <div class="form-group">
                    <label for="landlord-first-name">Landlord's First Name<sup v-if="hasError(errorStart + '.landlord_first_name')" class="form-errors">*</sup></label>
                    <input
                        class="form-control"
                        type="text"
                        name="landlord-first-name"
                        placeholder="ie. Jules"
                        v-model="property.landlord_first_name"
                        @input="removeError(errorStart + '.landlord_first_name', $event)"
                    />
                </div>
            </div>
            <div class="sm-1-2">
                <div class="form-group">
                    <label for="landlord-last-name">Last Name<sup v-if="hasError(errorStart + '.landlord_last_name')" class="form-errors">*</sup></label>
                    <input
                        class="form-control"
                        type="text"
                        name="landlord-last-name"
                        placeholder="ie. Verne"
                        v-model="property.landlord_last_name"
                        @input="removeError(errorStart + '.landlord_last_name', $event)"
                    />
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="landlord-email">Landlord's Email<sup v-if="hasError(errorStart + '.landlord_email')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                type="text"
                name="landlord-email"
                placeholder="ie. captainnemo@thenautilus.com"
                v-model="property.landlord_email"
                @input="removeError(errorStart + '.landlord_email', $event)"
            />
        </div>
        <div class="form-errors" v-if="errorExists">
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
            errorStart() { return 'rental_histories[' + this.idx + ']' }
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