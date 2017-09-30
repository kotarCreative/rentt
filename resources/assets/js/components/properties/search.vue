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
                    <label for="bedroom-count">Bedrooms</label>
                    <select class="form-control"
                            name="bedrooms"
                            v-model="bedroomCount">
                        <option :value="null" disabled>Any</option>
                        <option value="0">Studio</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4+</option>
                    </select>
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
                    bedrooms: this.bedroomCount
                };

                if (this.redirect) {
                    var base = '/properties?';
                    if (this.where != null) { base += '&where=' + this.where; }
                    if (this.bedroomCount != null) { base += '&bedrooms=' + this.bedroomCount; }
                    redirectTo(base);
                }
                this.$store.dispatch('properties/search', params);
            }
        }
    }
</script>

<style lang="sass">
    .search
        margin-top: 18px
</style>
