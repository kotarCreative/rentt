<template>
    <div class="vue2-photo" :class="{ selected: isSelected }">
        <button class="remove-btn" @click="remove">&times;</button>
        <div class="image" :style="'background-image: url('  + image + ')'" @click="clickEvent"></div>
    </div>
</template>

<script>
    export default {
        name: 'vue2-photo',

        props: {
            image: {
                required: true
            },

            index: {
                type: Number,
                required: true
            },

            isSelected: {
                type: Boolean,
                required: false
            }
        },

        methods: {
            remove() {
                this.$emit('removePhoto', this.index);
            },

            clickEvent() {
                this.$emit('selectPhoto', this.index);
            }
        }
    }
</script>

<style lang="sass" scoped>
    .vue2-photo
        width: 31%
        margin-right: 2%
        display: inline-block
        height: 200px
        position: relative

        .image
            height: 100%
            width: 100%
            background-size: cover
            background-repeat: no-repeat
            background-position: center

        .remove-btn
            background: none
            border: none
            color: #000
            cursor: pointer
            z-index: 21
            position: absolute
            top: 2px
            font-size: 20px
            right: 5px
            padding: 0px
            line-height: 1

        &.selected
            border: 2px solid red;
</style>
