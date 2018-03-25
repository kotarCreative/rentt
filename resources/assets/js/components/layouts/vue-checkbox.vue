<template>
    <div class="v-checkbox-wrapper">
        <template v-if="type == 'checkbox'">
            <label
                :for="name"
                class="v-checkbox-label"
                @click="update">
                <slot name="label"></slot>
            </label>
            <input
                type="checkbox"
                :name="name"
                :id="name"
                class="v-checkbox"
                ref="input"
            />
            <svg @click="update" width="15" height="15" viewBox="0 0 15 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <path class="v-checkbox-input" :class="{ checked: showCheck }" transform="translate(2 2)" d="M 0 2C 0 0.895431 0.895431 0 2 0L 9 0C 10.1046 0 11 0.895431 11 2L 11 9C 11 10.1046 10.1046 11 9 11L 2 11C 0.895431 11 0 10.1046 0 9L 0 2Z"/>
                <path transform="translate(4 5)" class="v-checkbox-check" d="M 2 5L 1.64645 5.35355L 2 5.70711L 2.35355 5.35355L 2 5ZM -0.353553 3.35355L 1.64645 5.35355L 2.35355 4.64645L 0.353553 2.64645L -0.353553 3.35355ZM 2.35355 5.35355L 7.35355 0.353553L 6.64645 -0.353553L 1.64645 4.64645L 2.35355 5.35355Z"/>
            </svg>
        </template>
        <template v-else>
            <div class="v-checkbox-radio-wrapper" v-for="option in options">
                <label
                    :for="option.val"
                    class="v-checkbox-label"
                    @click="update(option)">
                    <slot name="label" :option="option"></slot>
                </label>
                <input
                    type="radio"
                    :name="option.val"
                    :id="option.val"
                    class="v-checkbox"
                    :ref="option.val"
                />
                <svg @click="update(option)" width="15" height="15" viewBox="0 0 15 15" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <path class="v-checkbox-input" :class="{ checked: showCheck == option.val }" transform="translate(2 2)" d="M 0 2C 0 0.895431 0.895431 0 2 0L 9 0C 10.1046 0 11 0.895431 11 2L 11 9C 11 10.1046 10.1046 11 9 11L 2 11C 0.895431 11 0 10.1046 0 9L 0 2Z"/>
                    <path transform="translate(4 5)" class="v-checkbox-check" d="M 2 5L 1.64645 5.35355L 2 5.70711L 2.35355 5.35355L 2 5ZM -0.353553 3.35355L 1.64645 5.35355L 2.35355 4.64645L 0.353553 2.64645L -0.353553 3.35355ZM 2.35355 5.35355L 7.35355 0.353553L 6.64645 -0.353553L 1.64645 4.64645L 2.35355 5.35355Z"/>
                </svg>
            </div>
        </template>
    </div>
</template>

<script>
    export default {
        name: 'v-checkbox',

        props: {
            checkVal: {
                required: false
            },

            name: {
                type: String,
                required: true
            },

            options: {
                type: Array,
            },

            type: {
                type: String,
                default: 'checkbox'
            },

            value: {
                default: false
            }
        },

        data: () => ({
            showCheck: false
        }),

        mounted() {
            if (this.type == 'checkbox') {
                if (this.checkVal) {
                    if (this.value.indexOf(this.checkVal) > -1) {
                        this.showCheck = true;
                    }
                } else {
                    if (this.value) {
                        this.showCheck = true;
                    }
                }
            } else {
                if (this.value) { this.showCheck = this.value }
            }
        },

        methods: {
            update(option) {
                if (this.type == 'checkbox') {
                    this.updateCheckbox();
                } else {
                    this.updateRadio(option);
                }
            },

            updateCheckbox() {
                this.showCheck = !this.showCheck;
                this.$refs.input.value = this.showCheck;
                if (this.showCheck && this.checkVal) {
                    this.$emit('input', [ ...this.value, this.checkVal ]);
                } else if (!this.showCheck && this.checkVal) {
                    let idx = this.value.indexOf(this.checkVal);
                    this.value.splice(idx, 1);
                    this.$emit('input', this.value);
                } else {
                    this.$emit('input', this.showCheck);
                }
            },

            updateRadio(option) {
                this.showCheck = option.val
                this.$refs[option.val].value = this.showCheck;
                this.$emit('input', this.showCheck);
            }
        },

        watch: {
            value(val) {
                if (this.type == 'checkbox') {
                    if (this.checkVal) {
                        if (this.value.indexOf(this.checkVal) > -1) {
                            this.showCheck = true;
                        } else {
                            this.showCheck = false;
                        }
                    } else {
                        if (this.value) {
                            this.showCheck = true;
                        } else {
                            this.showCheck = false;
                        }
                    }
                } else {
                    if (this.value) { this.showCheck = this.value }
                }
            }
        }
    }
</script>
