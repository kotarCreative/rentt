<template>
    <div id="profile-reference-wrapper" class="creation-section-wrapper">
        <div class="references-header">
            <h2>References</h2>
            <button class="link" @click="addReference">Add a Reference</button>
        </div>
        <template v-if="references.length > 0">
            <reference v-for="(ref, idx) in references" :reference="ref" :idx="idx" :key="'reference-' + idx"></reference>
        </template>
        <p v-else>You currently don't have any references. Try adding some now.</p>
    </div>
</template>

<script>
    import ErrorMixins from '../../../../mixins/errorMixins';
    import Reference from './forms/reference';

    export default {
        name: 'references-form',

        mixins: [ ErrorMixins ],

        components: {
            Reference
        },

        computed: {
            references() {
                return this.$store.getters['users/active'].references;
            }
        },

        methods: {
            addReference() {
                this.$store.commit('users/addReference');
            }
        }
    }
</script>
