<template>
    <div id="account-creation">
        <h2>Create Account</h2>
        <div class="form-group">
            <label for="user-type">Are you a landlord or a tenant?</label>
            <v-checkbox v-model="userType"
                name="user-type"
                :options="userTypes"
                type="radio">
                <span slot="label" slot-scope="{ option }">{{ option.label }}</span>
            </v-checkbox>
        </div>
        <div class="form-group">
            <label for="email">Email<sup v-if="hasError('password')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                type="text"
                name="email"
                placeholder="ie. captainnemo@thenautilus.com"
                v-model="email"
            />
        </div>
        <div class="form-group">
            <label for="password">Password<sup v-if="hasError('password')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                type="password"
                name="password"
                placeholder="mysteriousIsland"
                v-model="password"
            />
        </div>
        <div class="form-group">
            <label for="password">Confirm Password<sup v-if="hasError('password')" class="form-errors">*</sup></label>
            <input
                class="form-control"
                type="password"
                name="confirmed"
                v-model="confirmed"
            />
        </div>
        <div class="form-errors" v-if="hasErrors()">
            <sup>*</sup>Please Complete Required Fields
        </div>
        <button
            class="btn"
            type="button"
            @click="save"
        >Create Account</button>
    </div>
</template>

<script>
    import ErrorMixins from '../../mixins/errorMixins';

    export default {
        name: 'account-creation-form',

        mixins: [ ErrorMixins ],

        data: () =>  ({
            confirmed: null,
            email: null,
            password: null,
            userType: 'tenant',
            userTypes: [
                {
                    val: 'landlord',
                    label: 'Landlord'
                },
                {
                    val: 'tenant',
                    label: 'Tentant'
                }
            ],
        }),

        methods: {
            save() {}
        }
    }
</script>
