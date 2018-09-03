<template>
    <div class="image-uploader__grid">
        <input ref="input" type="file" multiple class="image-uploader__input" @change="uploadPhotos($event)">
        <photo v-if="singlePhoto"
               :key="'photo-' + 0"
               :image="renderedImages[0]"
               :new-image="files[0]"
               :index="0"
               :single="true"
               @clickPhoto="openPhotoUploader"
               @removePhoto="removePhoto"
               @imageRendered="addNewImage"></photo>
        <template v-else>
            <div class="image-uploader__grid-row">
                <photo v-for="n in [0, 1, 2]"
                       :key="'photo-' + n"
                       :image="renderedImages[n]"
                       :index="n"
                       :dragIdx="dragIdx"
                       :new-image="files[n]"
                       @clickPhoto="openPhotoUploader"
                       @removePhoto="removePhoto"
                       @imageRendered="addNewImage"
                       @startDragging="dragStartHandler"
                       @dragEnter="dragEnterHandler"
                       @stopDragging="dragEndHandler"></photo>
            </div>
            <div class="image-uploader__grid-row">
                <photo v-for="n in [3, 4, 5]"
                       :key="'photo-' + n"
                       :image="renderedImages[n]"
                       :index="n"
                       :dragIdx="dragIdx"
                       :new-image="files[n]"
                       @clickPhoto="openPhotoUploader"
                       @removePhoto="removePhoto"
                       @imageRendered="addNewImage"
                       @startDragging="dragStartHandler"
                       @dragEnter="dragEnterHandler"
                       @stopDragging="dragEndHandler"></photo>
            </div>
            <div class="image-uploader__grid-row">
                <photo v-for="n in [6, 7, 8]"
                       :key="'photo-' + n"
                       :image="renderedImages[n]"
                       :index="n"
                       :dragIdx="dragIdx"
                       :new-image="files[n]"
                       @clickPhoto="openPhotoUploader"
                       @removePhoto="removePhoto"
                       @imageRendered="addNewImage"
                       @startDragging="dragStartHandler"
                       @dragEnter="dragEnterHandler"
                       @stopDragging="dragEndHandler"></photo>
            </div>
        </template>
    </div>
</template>

<script>
    import Photo from './photo';

    export default {
        name: 'image-grid',

        components: {
            Photo
        },

        props: {
            singlePhoto: {
              type: Boolean,
              default: false
            },

            startingImages: {
                type: Array,
                default: _ => []
            }
        },

        data: _ => ({
            dragIdx: -1,
            files: [],
            renderedImages: [],
            images: [],
            uploaderStartIdx: -1
        }),

        mounted() {
            for (var i = 0; i < 9; i++) {
                this.files.push(null);
                this.images.push(null);
                this.renderedImages.push(null);
            }

            this.startingImages.forEach((img, idx) => {
                if (img && img.name !== undefined) {
                  this.files.splice(idx, 1, img);
                }
                this.images.splice(idx, 1, img);
                this.renderedImages.splice(idx, 1, img);
            });
        },

        methods: {
            addNewImage({ img, idx, renderedImage }) {
                this.images.splice(idx, 1, img);
                this.renderedImages.splice(idx, 1, renderedImage);
            },

            dragEndHandler(idx) {
                this.dragIdx = -1;
            },

            dragEnterHandler(idx) {
                // Drag to the right
                if (this.dragIdx < idx) {
                    var temp = this.images[idx],
                        renderTemp = this.renderedImages[idx],
                        rollingTemp,
                        renderRollingTemp;
                    this.$set(this.images, idx, this.images[this.dragIdx]);
                    this.$set(this.renderedImages, idx, this.renderedImages[this.dragIdx]);
                    for (var i = idx - 1; i >= this.dragIdx; i--) {
                        rollingTemp = this.images[i];
                        renderRollingTemp = this.renderedImages[i];
                        this.$set(this.images, i, temp);
                        this.$set(this.renderedImages, i, renderTemp);
                        temp = rollingTemp;
                        renderTemp = renderRollingTemp;
                    }
                    this.dragIdx = idx;
                // Drag to the left
                } else if (this.dragIdx > idx) {
                    var temp = this.images[idx],
                        renderTemp = this.renderedImages[idx],
                        rollingTemp,
                        renderRollingTemp;
                    this.$set(this.images, idx, this.images[this.dragIdx]);
                    this.$set(this.renderedImages, idx, this.renderedImages[this.dragIdx]);
                    for (var i = idx + 1; i <= this.dragIdx; i++) {
                        rollingTemp = this.images[i];
                        renderRollingTemp = this.renderedImages[i];
                        this.$set(this.images, i, temp);
                        this.$set(this.renderedImages, i, renderTemp);
                        temp = rollingTemp;
                        renderTemp = renderRollingTemp;
                    }
                    this.dragIdx = idx;
                }
            },

            dragStartHandler(idx) {
                this.dragIdx = idx;
            },

            openPhotoUploader(idx) {
                this.uploaderStartIdx = idx;
                this.$refs.input.click();
            },

            removePhoto(idx) {
                this.images.splice(idx, 1, null);
                this.renderedImages.splice(idx, 1, null);
                this.files.splice(idx, 1, null);
            },

            uploadPhotos(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length) {
                    return;
                }
                for (var i = 0; i < files.length; i++) {
                    if (i > 8) {
                        break;
                    }
                    this.files.splice(i + this.uploaderStartIdx, 1, files[i]);
                }
            },
        },

        watch: {
            images(val) {
                if (this.singlePhoto) {
                  this.$store.commit('users/setActivePicture', this.images[0]);
                } else {
                  this.$store.commit('properties/setActiveImages', this.images);
                }
            }
        }
    }
</script>

<style lang="sass">
    .image-uploader
        &__grid
            display: flex
            flex-direction: column

        &__grid-row
            display:         flex
            justify-content: space-between
            margin-bottom:   20px

        &__input
            display: none

    .mobile-show
        display: none

</style>
