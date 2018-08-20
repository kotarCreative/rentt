<template>
    <div class="photo" :style="'height: ' + height + 'px;'" @click="clickEvent">
        <div class="loading-bg" v-if="loading">
            <loader></loader>
        </div>
        <div class="photo-action-bar" v-if="image !== null">
            <button class="remove-btn" @click.stop="remove">&times;</button>
        </div>
        <div v-if="image !== null" class="image" :style="'background-image: url('  + currentImage + ')'"></div>
    </div>
</template>

<script>
    import imageLoader from 'blueimp-load-image';
    import Loader from './loader';

    export default {
        name: 'vue2-photo',

        components: {
            Loader
        },

        props: {
            image: {
                type: [ String, File ]
            },

            index: {
                type: [ String, Number ],
                required: true
            },

            newImage: {
                type: File
            }
        },

        data: _ => ({
            renderedImage: null,
            height: 0,
            loading: false
        }),

        mounted() {
            var width = this.$el.clientWidth;

            this.height = width;
        },

        computed: {
            currentImage() {
                return this.renderedImage ? this.renderedImage : this.image;
            }
        },

        methods: {
            remove() {
                this.$emit('removePhoto', this.index);
            },

            clickEvent() {
                this.$emit('clickPhoto', this.index);
            },

            finishRenderingImage(e) {
                this.renderedImage = e.toDataURL();
                this.$emit('imageRendered', { img: this.newImage, idx: this.index });
                this.loading = false;
            }
        },

        watch: {
            newImage(file) {
                if (file !== null) {
                    this.loading = true;
                    imageLoader(file,
                        this.finishRenderingImage,
                        {
                            canvas: true,
                            orientation: true
                        });
                }
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
            background:                 #33333366
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

                &:focus
                    outline: none

        &.selected
            border: 2px solid red

        &:hover
            .photo-action-bar
                opacity: 1

    .loading-bg
        position:        absolute
        width:           100%
        height:          100%
        display:         flex
        justify-content: center
        align-items:     center
        top:             0px
        left:            0px
        background:      #33333344
        border-radius:   $border-radius
</style>