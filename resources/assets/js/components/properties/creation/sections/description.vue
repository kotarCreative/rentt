<template>
    <div id="property-address-wrapper" class="creation-section-wrapper">
        <h2>Description</h2>
        <div class="form-group">
            <label for="title">Listing Title</label>
            <input
                class="form-control"
                name="title"
                type="text"
                v-model="property.title"
                placeholder="Anything">
        </div>
        <div class="form-group">
            <label for="city">When is the suite available?</label>
            <datepicker
                class="datepicker"
                format="MMM d, yyyy"
                placeholder="Any time"
                v-model="property.available_at"
                :disabled="{ to: new Date() }">
            </datepicker>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input
                class="form-control"
                name="price"
                type="text"
                v-model="property.price"
                placeholder="Any">
        </div>
        <div class="form-group">
            <label for="deposit">Damage Deposit</label>
            <input
                class="form-control"
                name="deposit"
                type="text"
                v-model="property.damage_deposit"
                placeholder="Any">
        </div>
        <div class="form-group">
            <label for="postal">Description</label>
            <div class="text-area">
                <textarea
                    class="form-control"
                    v-model="property.description"
                    maxlength="500"
                    placeholder="Write your description here..."></textarea>
                <span class="word-count">500</span>
            </div>
        </div>
    </div>
</template>

<script>
    import Datepicker from "vuejs-datepicker"

    export default {
        name: 'property-creation-description',

        components: {
            Datepicker
        },

        computed: {
            property() {
                return this.$store.getters['properties/active'];
            }
        }
    }
</script>
