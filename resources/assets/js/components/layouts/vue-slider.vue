<template>
    <div class="range-slider">

    </div>
</template>

<script>
    export default {
        name: 'range-slider',

        props: {
            max: {
                type: Number,
                default: 100
            },

            min: {
                type: Number,
                default: 0
            },

            step: {
                type: Number,
                default: 1
            },

            value: {
                type: Array,
                required: true
            }
        },

        methods: {
            update(idx) {
                var newVal = this.value;
                newVal.splice(idx, 1, parseInt(this.$refs['input' + idx].value));
                if (newVal[0] >= newVal[1]) {
                    newVal[0] = newVal[1] - 3;
                }

                if (newVal[1] <= newVal[0]) {
                    newVal[1] = newVal[0] + 3;
                }

                this.$emit('input', newVal);
            }
        }
    }
</script>

<style lang="sass">
    /*.range-slider
        position: relative
        width: 800px
        margin: 0 auto 20px
        height: 35px
        text-align: center

        input[type="range"]
            pointer-events: none
            position: absolute
            left: 0; top: 15px
            width: 100%
            outline: none
            height: 18px
            margin: 0
            padding: 0
            border-radius: 8px

            &::-webkit-slider-thumb, &::-moz-range-thumb, &-ms-thumb
                pointer-events: all
                position: relative
                z-index: 1
                outline: 0
                appearance: none
                height: 24px
                width: 24px
                border-radius: 12px
                background-color: white
                border: 2px solid black*/
</style>
