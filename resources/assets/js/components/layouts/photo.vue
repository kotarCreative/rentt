<template>
    <div class="photo"
         :class="[{ invisible: dragIdx == index }, { single: single }]"
         :style="'height: ' + height + 'px;'"
         @click="clickEvent"
         :draggable="!single"
         @dragstart="dragStartHandler($event)"
         :ondragstart="dragNativeFunction"
         @dragenter.prevent="dragEnterHandler($event)"
         @dragend="dragEndHandler">
        <div class="loading-bg" v-if="loading">
            <loader></loader>
        </div>
        <div v-if="index == 0 && !single" class="photo-main-banner">
            Main
        </div>
        <div class="photo-action-bar" v-if="image !== null">
            <button class="remove-btn" @click.stop="remove">&times;</button>
        </div>
        <div v-if="image !== null" class="image" :style="'background-image: url('  + image + ')'"></div>
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
            dragIdx: {
                type: Number
            },

            image: {
                type: [ String, File ]
            },

            index: {
                type: [ String, Number ],
                required: true
            },

            newImage: {
                type: File
            },

            single: {
              type: Boolean,
              default: false
            }
        },

        data: _ => ({
            height: 0,
            loading: false,
        }),

        mounted() {
            var width = this.$el.clientWidth;

            this.height = width;
        },

        computed: {
          dragNativeFunction() {
            return 'return ' + (this.single ? 'false;' : 'true;');
          }
        },

        methods: {
            clickEvent() {
                this.$emit('clickPhoto', this.index);
            },

            dragEndHandler() {
                this.$emit('stopDragging', this.index);
            },

            dragEnterHandler() {
                this.$emit('dragEnter', this.index);
            },

            dragStartHandler(e) {
                e.dataTransfer.setData('text/html', this.$el.innerHTML);
                this.$emit('startDragging', this.index);
            },

            finishRenderingImage(e) {
                var output = {
                    img: this.newImage,
                    idx: this.index,
                    renderedImage: e.toDataURL()
                };
                this.$emit('imageRendered', output);
                this.loading = false;
            },

            remove() {
                this.$emit('removePhoto', this.index);
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
                            orientation: true,
                            maxWidth: 400
                        });
                }
            }
        }
    }
</script>

<style lang="sass" scoped>
    $border-radius: 5px

    .photo
        width:              31.33333%
        max-width:          31.33333%
        flex:               1
        position:           relative
        background:         #33333322
        border-radius:      $border-radius
        cursor:             move
        background:         url('/imgs/img-placeholder.png')
        background-repeat:  no-repeat
        background-size:    contain

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
            background:                 #333333ee
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

            @media screen and (max-width: 956px)
                &
                    opacity: 1

        &.invisible
            opacity: 0;

        &:hover
            .photo-action-bar
                opacity: 1

        &.single
          width:     100%
          max-width: 500px
          margin:    0px auto
          cursor:    pointer

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

    [draggable]
      -moz-user-select:     none
      -khtml-user-select:   none
      -webkit-user-select:  none
      user-select:          none
      /* Required to make elements draggable in old WebKit */
      -khtml-user-drag:     element
      -webkit-user-drag:    element

    .photo-main-banner
        position:                       absolute
        text-align:                     center
        bottom:                         0px
        width:                          100%
        font-family:                    "Roboto", sans-serif
        padding:                        5px
        background:                     #333333ee
        color:                          #fff
        border-bottom-left-radius:      $border-radius
        border-bottom-right-radius:     $border-radius
</style>
