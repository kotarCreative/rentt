<template>
    <div id="property-search-bar">
        <div class="row">
            <div class="xs-1-1" :class="[{ 'sm-2-3': !inHeader }]">
                <div class="form-group">
                    <label for="where">Where</label>
                    <input
                        id="location-search-input"
                        class="form-control"
                        type="text"
                        name="where"
                        placeholder="Anywhere"
                        v-model="whereSearch"
                        @keydown.enter="search"
                    />
                </div>
            </div>
            <div class="xs-1-1 sm-1-3" v-if="!inHeader">
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

        data: () => ({
            timeout: null,
            whereSearch: null
        }),

        props: {

            inHeader: {
                default: false
            },

            redirect: {
                type: Boolean,
                default: true
            },

            where: {
                default: null
            }
        },

        methods: {
            search() {
                if (this.redirect) {
                    var base = '/properties?';
                    if (this.whereSearch != null) {
                        base += '&where=' + this.whereSearch;
                    }
                    redirectTo(base);
                } else {
                    if (this.timeout) { clearTimeout(this.timeout) }

                    this.timeout = setTimeout(() => {
                        this.$store.commit('properties/updateSearch', { key: 'where', val: this.whereSearch });
                        this.$store.dispatch('properties/search');
                    }, 2000);
                }
            }
        },

        watch: {
            where(val) { this.whereSearch = val }
        }
    }
</script>

<style lang="sass">
    .search
        margin-top: 18px
        width: 100%
</style>
