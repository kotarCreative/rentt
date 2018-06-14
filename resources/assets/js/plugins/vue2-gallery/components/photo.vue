<template>
    <div class="vue2-photo" :class="{ selected: isSelected }" :style="'height: ' + height + 'px;'">
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

        data: _ => ({
            height: 0
        }),

        mounted() {
            var width = this.$el.clientWidth;

            this.height = width;
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
        width:          31.33333%
        margin-right:   3%
        display:        inline-block
        position:       relative

        &:last-of-type
            margin-right: 0px

        .image
            height:                 100%
            width:                  100%
            background-size:        cover
            background-repeat:      no-repeat
            background-position:    center
            border-radius:          5px

        .remove-btn
            background:     none
            border:         none
            color:          #000
            cursor:         pointer
            z-index:        21
            position:       absolute
            top:            2px
            font-size:      25px
            right:          5px
            padding:        0px
            line-height:    1
            opacity:        0
            transition:     opacity 0.5s ease-in

        &.selected
            border: 2px solid red

        &:hover
            .remove-btn
                opacity: 1
</style>
