<template>
    <div class="image-uploader__grid">
        <input type="file" multiple id="image-uploader__input" @change="uploadPhotos($event)">
        <div class="image-uploader__grid-row">
            <photo v-for="n in [0, 1, 2]"
                   :key="'photo-' + n"
                   :image="images[n]"
                   :index="n"
                   :new-image="files[n]"
                   @clickPhoto="openPhotoUploader"
                   @removePhoto="removePhoto"
                   @imageRendered="addNewImage"></photo>
        </div>
        <div class="image-uploader__grid-row">
            <photo v-for="n in [3, 4, 5]"
                   :key="'photo-' + n"
                   :image="images[n]"
                   :index="n"
                   :new-image="files[n]"
                   @clickPhoto="openPhotoUploader"
                   @removePhoto="removePhoto"
                   @imageRendered="addNewImage"></photo>
        </div>
        <div class="image-uploader__grid-row">
            <photo v-for="n in [6, 7, 8]"
                   :key="'photo-' + n"
                   :image="images[n]"
                   :index="n"
                   :new-image="files[n]"
                   @clickPhoto="openPhotoUploader"
                   @removePhoto="removePhoto"
                   @imageRendered="addNewImage"></photo>
        </div>
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
            startingImages: {
                type: Array,
                default: _ => []
            }
        },

        data: _ => ({
            files: [],
            images: [],
            uploaderStartIdx: -1
        }),

        mounted() {
            for (var i = 0; i < 9; i++) {
                this.files.push(null);
                this.images.push(null);
            }

            this.startingImages.forEach((img, idx) => {
                this.images.splice(idx, 1, img);
            })
        },

        methods: {
            addNewImage({ img, idx }) {
                this.images.splice(idx, 1, img);
            },

            openPhotoUploader(idx) {
                this.uploaderStartIdx = idx;
                document.getElementById('image-uploader__input').click();
            },

            removePhoto(idx) {
                this.images.splice(idx, 1);
            },

            uploadPhotos(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length) {
                    return;
                }

                for (var i = 0; i < files.length; i++) {
                    this.files.splice(i + this.uploaderStartIdx, 1, files[i]);
                }
            },
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

    #image-uploader__input
        display: none

</style>