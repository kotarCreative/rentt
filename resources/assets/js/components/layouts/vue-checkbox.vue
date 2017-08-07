<template>
    <div class="v-checkbox-wrapper">
        <label
            :for="name"
            class="v-checkbox-label">Remember?</label>
        <input
            :v-model="model"
            :type="type"
            :name="name"
            :id="id"
            class="v-checkbox"
        />
        <div class="v-checkbox-input"></div>
    </div>
</template>

<script>
    export default {
        name: 'v-checkbox',

        props: {
            name: {
                type: String,
                required: true
            },

            type: {
                type: String,
                required: true,
                validator(val) {
                    return val == 'checkbox' || val == 'radio';
                }
            },

            id: {
                type: String,
                required: true
            },

            model: {
                required: true
            }
        }
    }
</script>

<style lang="scss" scoped>
    $checked-color: #000;
    $text-color: #000;
    .v-checkbox-wrapper, .v-checkbox-wrapper {
        position: relative;
        display: inline-block;
        height: 30px;
        cursor: pointer;

        .v-checkbox-label {
            position: relative;
            display: block;
            margin: 10px auto;
            height: 30px;
            z-index: 9;
            padding: 0px 20px;
            cursor: pointer;
        }

        .v-checkbox {
            position: absolute;
            visibility: hidden;

            &:checked {
                & ~ .v-checkbox-input {
                    border: 2px solid $checked-color;
                }

                & ~ .v-checkbox-input::before {
                    background: $checked-color;
                }

                & ~ v-checkbox-label {
                    color: $checked-color;
                }
            }
        }

        .v-checkbox-input {
            display: block;
            position: absolute;
            border: 2px solid $text-color;
            border-radius: 100%;
            height: 15px;
            width: 15px;
            top: 14px;
            z-index: 5;
            transition: border .25s linear;
            -webkit-transition: border .25s linear;

            &::before {
                display: block;
                position: absolute;
                content: '';
                border-radius: 100%;
                height: 13px;
                width: 13px;
                top: -1px;
                left: -1px;
                margin: auto;
                transition: background 0.25s linear;
                -webkit-transition: background 0.25s linear;
            }
        }
    }
</style>
