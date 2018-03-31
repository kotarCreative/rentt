<template>
    <div id="profile-history-wrapper" class="creation-section-wrapper">
        <div class="history-header">
            <h2>Rental History</h2>
            <button class="link" @click="addProperty">Add a Property</button>
        </div>
        <historic-property v-for="(prop, idx) in properties" :property="prop" :idx="idx" :key="idx"></historic-property>
        <div class="form-errors" v-if="hasErrors()">
            <sup>*</sup>Please Complete Required Fields
        </div>
    </div>
</template>

<script>
    import ErrorMixins from '../../../../mixins/errorMixins';
    import HistoricProperty from './forms/property';

    export default {
        name: 'references-form',

        mixins: [ ErrorMixins ],

        components: {
            HistoricProperty
        },

        computed: {
            properties() {
                return this.$store.getters['users/active'].rental_history;
            }
        },

        methods: {
            addProperty() {
                this.$store.commit('users/addProperty');
            }
        }
    }
</script>