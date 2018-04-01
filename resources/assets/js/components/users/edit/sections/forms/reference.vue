<template>
    <div class="reference-form">
        <div class="reference-form-header">
            {{ idx + 1}}.
            <div class="text-btn" @click="removeReference">remove</div>
        </div>
        <div class="form-group">
            <label for="first-name">First Name<sup v-if="hasError(errorStart + '.first_name')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                type="text"
                name="first-name"
                placeholder="ie. Jules"
                v-model="reference.first_name"
                @input="removeError(errorStart + '.first_name', $event)"
            />
        </div>
        <div class="form-group">
            <label for="last-name">Last Name<sup v-if="hasError(errorStart + '.last_name')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                type="text"
                name="last-name"
                placeholder="ie. Verne"
                v-model="reference.last_name"
                @input="removeError(errorStart + '.last_name', $event)"
            />
        </div>
        <div class="form-group">
            <label for="relationship">Relationship</label>
            <v-select class="form-control no-indicator single"
                      name="relationship"
                      v-model="reference.relationship"
                      :options="relationships"
                      :clearable="false"
                      placeholder="none">
            </v-select>
        </div>
        <div class="form-group">
            <label for="email">Email<sup v-if="hasError(errorStart + '.email')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                type="text"
                name="email"
                placeholder="ie. captainnemo@thenautilus.com"
                v-model="reference.email"
                @input="removeError(errorStart + '.email', $event)"
            />
        </div>
        <div class="form-errors" v-if="hasError(errorStart + '.first_name') || hasError(errorStart + '.last_name') || hasError(errorStart + '.email')">
            <sup>*</sup>Please Complete Required Fields
        </div>
    </div>
</template>

<script>
    import ErrorMixins from '../../../../../mixins/errorMixins';

    export default {
        name: 'reference-form',

        mixins: [ ErrorMixins ],

        props: {
            idx: {
                type: Number,
                required: true
            },

            reference: {
                required: true
            }
        },

        data: () => ({
            errorModel: 'users',
            relationships: [
                'Family',
                'Friend',
                'Co-Worker',
                'Employer'
            ]
        }),

        computed: {
            errorStart() { return 'references.' + this.idx }
        },

        methods: {
            removeReference() {
                this.$store.commit('users/removeReference', this.idx);
            }
        }
    }
</script>