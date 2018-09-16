<template>
    <div class="vueplete__wrapper" :class="[{ open: mobileOpen || !mobileHide }, { 'search-hidden': mobileHide }]">
        <div class="vueplete__search">
          <div class="vueplete__input-wrapper">
              <div v-if="loading" class="loader"></div>
              <div v-else class="search-icon" @click="mobileOpen = !mobileOpen">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21">
                      <g stroke-width="3" stroke="#6c6c6c" fill="none">
                          <path d="M18.29 18.71l-6-6"/>
                          <circle cx="8" cy="8" r="6"/>
                      </g>
                  </svg>
              </div>
              <input :name="name"
                     ref="input"
                     class="vueplete__input"
                     @keyup="search($event)"
                     @blur="hideDropdown"
                     @focus="open = true"
                     autocomplete="off"
                     @keydown.down.prevent="moveDown"
                     @keydown.up.prevent="moveUp"
                     @keyup.enter.prevent="selectOption()"
                     :placeholder="placeholder" />
          </div>
          <button v-if="!mobileHide" class="btn" @click="selectOption()">Search</button>
        </div>
        <div  v-if="open && !loading" ref="optionsMenu" class="vueplete__options-wrapper">
            <ul class="vueplete__options">
                <li v-for="(option, idx) in availableOptions"
                    @mousedown="selectOption(option)"
                    :class="{ highlight: idx === optionIdx }">
                    {{ getOption(option) }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'vueplete',

        props: {
            getOption: {
                type: Function,
                default: option => {
                    return option;
                }
            },

            name: {
                type: String,
                default: 'search'
            },

            placeholder: {
                type: String,
                default: 'Search...'
            },

            mobileHide: {
                type: Boolean,
                default: true
            },

            options: {
                type: Array,
                default: _ => []
            },

            url: {
                type: String
            },

            value: {
                type: [ Object, String ]
            }
        },

        data: _ => ({
            availableOptions: [],
            loading: false,
            mobileOpen: false,
            open: false,
            optionIdx: -1,
            searchComplete: true
        }),

        mounted() {
            this.availableOptions = this.options;
        },

        methods: {
            closeEvent(option) {
                this.open = false;
                this.mobileOpen = false;
                this.optionIdx = -1;
                this.availableOptions = [];
                this.$emit('input', option);
            },

            hideDropdown() {
                this.closeEvent(this.$refs.input.value);
            },

            moveDown() {
                if (this.optionIdx < this.availableOptions.length - 1) {
                    this.optionIdx++;
                    this.$refs.optionsMenu.scrollTop = this.optionIdx * 45;
                }
            },

            moveUp() {
                if (this.optionIdx > 0) {
                    this.optionIdx--;
                    this.$refs.optionsMenu.scrollTop = this.optionIdx * 45;
                }
            },

            selectOption(option) {
                if (!option && this.optionIdx > -1) {
                    option = this.availableOptions[this.optionIdx];
                }

                if (!option) {
                    option = this.$refs.input.value;
                }

                this.$refs.input.value = typeof option === 'object' ? this.getOption(option): null;
                this.closeEvent(option);
                this.$emit('selectOption', option);
            },

            search(e) {
                // Don't search on arrow up or down
                if ([ 37, 38, 39, 40 ].indexOf(e.keyCode) > -1) {
                    return;
                }

                var search = this.$refs.input.value;

                if (search == '') {
                    this.availableOptions = [];
                    return;
                }

                setTimeout(_ => {
                    if (!this.searchComplete) {
                        this.loading = true;
                    }
                }, 500);

                this.searchComplete = false;
                axios.get(this.url, { params: { search: search } })
                    .then(response => {
                        this.loading = false;
                        this.searchComplete = true;
                        this.availableOptions = response.data.cities;
                    })
                    .catch(errors => {
                        console.error(errors);
                    });
            }
        },

        watch: {
            value(val) {
                this.$refs.input.value = val && typeof val === 'object' ? this.getOption(val) : val;
            }
        }
    }
</script>

<style lang="sass">

    .vueplete
        &__search
            display: flex

            .btn
              border-top-left-radius:    0px
              border-bottom-left-radius: 0px

        &__input-wrapper
            flex: 1

        &__wrapper
            position: relative
            transition: width 0.5s ease-in

            input
                transition:                 border-color 0.5s ease-in
                padding-left:               37px
                width:                      100%
                margin-bottom:              0px
                height:                     40px
                border:                     solid thin #dddddd
                font-size:                  16px
                color:                      #333
                border-top-left-radius:     5px
                border-bottom-left-radius:  5px
                border-right:               none

                &:focus
                    outline: none

            .search-icon
                position: absolute
                top:      10px
                left:     10px

            .loader
                border:         6px solid #f3f3f3 /* Light grey */
                border-top:     6px solid #444 /* Dark grey */
                border-radius:  50%
                width:          20px
                height:         20px
                position:       absolute
                animation:      spin 2s linear infinite
                top:            10px
                left:           10px

            @keyframes spin
                0%
                    transform: rotate(0deg)
                100%
                    transform: rotate(360deg)

            &.search-hidden
                input
                    border-right:                solid thin #dddddd
                    border-top-right-radius:     5px
                    border-bottom-right-radius:  5px

        &__options-wrapper
            position:           absolute
            z-index:            9998
            border-top:         none
            max-height:         180px
            overflow-y:         scroll
            margin-top:         0px
            width:              100%
            background-color:   #fff

        &__options
            list-style: none
            padding: 0px
            margin: 0px
            width: 100%

            & li
                border:         thin solid #dddddd
                border-top:     none
                padding:        8px
                cursor:         pointer

                &:hover
                    background-color: #dddddd

                &:focus
                    background-color: #dddddd

                &.highlight
                    background-color: #dddddd

    @media screen and (max-width: 956px)
        .vueplete
            &__wrapper
                width: 37px
                margin-left: auto

                &.open
                    width: 100%

                &:not(.open)
                    input
                        border-color: white
            &__search
                .btn
                    padding: 8px
</style>
