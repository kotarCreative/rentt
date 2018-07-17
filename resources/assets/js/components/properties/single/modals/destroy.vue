<template>
    <vue-modal name="destroy-property" class="destroy-property-modal">
        <h2 slot="header">Delete Property</h2>
        <p>Are you sure you want to permanently delete this listing? You can remove it from the search by setting it to inactive or occupied in the settings panel.</p>
        <div class="modal-actions">
            <button class="btn" @click="closeModal">No</button>
            <button class="btn" @click="destroy">Yes</button>
        </div>
    </vue-modal>
</template>

<script>
    export default {
        name: 'property-destroy-modal',

        data: _ => ({
            successful: false
        }),

        computed: {
            property() {
                return this.$store.getters['properties/active'];
            }
        },

        methods: {
            closeModal() {
                this.$modals.hide('destroy-property');
            },

            destroy() {
                this.$store.dispatch('properties/destroy');
            },
        }
    }
</script>
