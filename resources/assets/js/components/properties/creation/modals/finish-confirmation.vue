<template>
    <vue-modal name="property-finish">
        <h2 slot="header">Really post listing?</h2>
        <p>Are you sure you want to post this listing? The property will become available in the search and users will start contacting you about your listing.</p>
        <div class="modal-actions">
            <button class="btn listing-btn" @click="cancel">Cancel</button>
            <button class="btn" @click="save">Confirm</button>
        </div>
    </vue-modal>
</template>

<script>
    export default {
        name: 'property-finish-modal',

        computed: {
            property() {
                return this.$store.getters['properties/active'];
            }
        },

        methods: {
            cancel() {
                this.$modals.hide('property-finish');
            },

            save() {
                if (this.property.id) {
                    this.$store.dispatch('properties/update', {
                        isActive: true
                    });
                } else {
                    this.$store.dispatch('properties/store', true);
                }

                this.$modals.hide('property-finish');
            }
        }
    }
</script>
