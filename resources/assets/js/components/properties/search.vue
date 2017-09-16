<template>
    <div id="property-search-bar">
        <div class="row">
            <div class="xs-1-1 sm-1-3">
                <div class="form-group">
                    <label for="where">Where</label>
                    <input
                        class="form-control"
                        type="text"
                        name="where"
                        placeholder="Anywhere"
                        v-model="where"
                    />
                </div>
            </div>
            <div class="xs-1-1 sm-1-3">
                <div class="form-group">
                    <label for="bedroom-count">Where</label>
                    <input
                        class="form-control"
                        type="text"
                        name="bedroom-count"
                        placeholder="Any"
                        v-model="bedroomCount"
                    />
                </div>
            </div>
            <div class="xs-1-1 sm-1-3">
                <button
                    class="btn search"
                    @click="search"
                >Search</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'property-search',

        data() {
            return {
                where: null,
                bedroomCount: null
            }
        },

        props: {
            redirect: {
                type: Boolean,
                default: true
            }
        },

        methods: {
            search() {
                var params = {
                    where: this.where,
                    bedroomCount: this.bedroomCount,
                    redirect: this.redirect
                };

                this.$store.dispatch('properties/search', params);
            }
        }
    }
</script>

<style lang="sass">
    .search
        margin-top: 18px
</style>
