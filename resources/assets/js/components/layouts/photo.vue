<template>
    <div class="photo" :class="{ selected: isSelected }" :style="'height: ' + height + 'px;'">
        <div class="photo-action-bar" v-if="typeof image !== 'undefined'">
            <button class="remove-btn" @click="remove">&times;</button>
        </div>
        <div class="image" :style="'background-image: url('  + image + ')'" @click="clickEvent"></div>
    </div>
</template>

<script>
    export default {
        name: 'vue2-photo',

        props: {
            image: {
                type: String
            },

            index: {
                type: String,
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
    $border-radius: 5px

    .photo
        width:          31.33333%
        max-width:      31.33333%
        flex:           1
        position:       relative
        background:     #33333322
        border-radius:  $border-radius

        &:last-of-type
            margin-right: 0px

        .image
            height:                 100%
            width:                  100%
            background-size:        cover
            background-repeat:      no-repeat
            background-position:    center
            border-radius:          $border-radius

        .photo-action-bar
            opacity:                    0
            position:                   absolute
            z-index:                    21
            top:                        0
            left:                       0
            display:                    flex
            width:                      100%
            padding:                    0px 5px
            padding-bottom:             3px
            background:                 #33333344
            border-top-left-radius:     $border-radius
            border-top-right-radius:    $border-radius

            .remove-btn
                background:     none
                border:         none
                cursor:         pointer
                font-size:      25px
                padding:        0px
                line-height:    0.8
                margin-left:    auto
                color:          #fff

        &.selected
            border: 2px solid red

        &:hover
            .photo-action-bar
                opacity: 1
</style>