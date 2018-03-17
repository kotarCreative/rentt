 <template>
    <div class="vue-gallery">
        <div class="main-image" :class="[ { empty: cachedImages.length == 0 }, { gallery: viewOnly }]">
            <input type="file"
                   multiple
                   accept="image/jpeg, image/png, image/jpg"
                   class="file-input"
                   @change="cacheImages"
                   v-if="!viewOnly"/>
            <i class="nav-arrow left" v-if="viewOnly" @click="goToPrevImage"></i>
            <img v-if="cachedImages.length > 0" :src="cachedImages[currentImageIdx].image">
            <div v-else class="file-input-message">Drag or Click to Upload Images</div>
            <i class="nav-arrow right" v-if="viewOnly" @click="goToNextImage"></i>
        </div>
        <div class="sub-gallery" v-if="!viewOnly">
            <!--<photo v-if="cachedImages.length > 3" :image="prevImage" :index="1" id="prev"></photo>-->
            <photo v-for="image in visibleImages"
                   :key="image.idx"
                   :image="image.image"
                   :index="image.idx"
                   @removePhoto="removePhoto(image.idx)"
                   @selectPhoto="selectPhoto(image.idx)"></photo>
            <!--<photo v-if="cachedImages.length > 3" :image="nextImage" :index="1" id="next"></photo>-->
        </div>
    </div>
</template>

<script>
    import Photo from './photo';

    export default {
        name: 'vue2-gallery',

        components: {
            Photo
        },

        props: {
            images: {
                type: Array
            },

            viewOnly: {
                type: Boolean,
                default: false
            },

            vuexGet: {
                type: String
            },

            vuexSet: {
                type: String
            }
        },

        data: () => ({
            files: [],
            cachedImages: [],
            currentImageIdx: 0
        }),

        mounted() {
            if (this.images) { this.cachedImages = this.images }
        },

        computed: {
            prevImage() {
                var idx = this.currentImageIdx - 1;
                if (idx > 0) {
                    return this.cachedImages[idx];
                } else if (this.cachedImages.length > 3) {
                    return this.cachedImages[this.cachedImages.length - 1];
                }
            },

            currentImage() {
                return this.cachedImages[this.currentImageIdx];
            },

            nextImage() {
                var idx = this.currentImageIdx + 1;
                if (typeof this.cachedImages[idx] !== 'undefined') {
                    return this.cachedImages[idx];
                } else if (this.cachedImages.length > 3) {
                    return this.cachedImages[0];
                }
            },

            visibleImages() {
                // No image looping needs to occur.
                if (this.cachedImages.length <= 3) return this.cachedImages;

                var idx = this.currentImageIdx;

                // Images currently visible do not wrap
                if (idx - 1 > -1 && idx + 1 < this.cachedImages.length) return this.cachedImages.slice(idx - 1, idx + 2);

                // Images wrap

                // Previous image
                if (idx - 1 < 0) {
                    var prevIdx = this.cachedImages.length - 1;
                } else {
                    var prevIdx = idx - 1;
                }

                // Next Image
                if (idx + 1 >= this.cachedImages.length) {
                    var nextIdx = 0;
                } else {
                    var nextIdx = idx + 1;
                }

                return [
                    this.cachedImages[prevIdx],
                    this.cachedImages[idx],
                    this.cachedImages[nextIdx]
                ];
            }
        },

        methods: {
            cacheImages(e) {
                    var files = e.target.files || e.dataTransfer.files;
                    if (!files.length) { return }
                    for (var i = 0; i < files.length; i++) {
                        this.createImage(files[i]);
                    }

                    if (this.vuexSet) {
                        this.$store.commit(this.vuexSet, this.files);
                    }
                    this.showLoader = false;
            },

            createImage(file) {
                var image = new Image();
                var reader = new FileReader();

                this.files.push(file);
                reader.onloadend = (e) => { this.cachedImages.push({ image: reader.result, idx: this.cachedImages.length }) }

                reader.readAsDataURL(file);
            },

            goToPrevImage() {
                let idx = this.currentImageIdx - 1;

                if (idx < 0) { this.currentImageIdx = this.images.length - 1 }
                else { this.currentImageIdx = idx }
            },

            goToNextImage() {
                let idx = this.currentImageIdx + 1;

                if (idx > this.images.length - 1) { this.currentImageIdx = 0 }
                else { this.currentImageIdx = idx }
            },

            removePhoto(idx) {
                this.files.splice(idx, 1);
                this.cachedImages.splice(idx, 1);
                this.cachedImages.forEach((image, idx) => {
                    image.idx = idx;
                });
            },

            selectPhoto(idx) {
                this.currentImageIdx = idx;
            }
        }
    }
</script>

<style lang="sass" scoped>
    .vue-gallery
        .sub-gallery
            overflow:   hidden
            position:   relative
            min-height: 200px

        .prev
            position:   absolute
            left:       -33%

        .next
            position:   absolute
            right:      -33%

        .file-input
            opacity:    0
            position:   absolute
            top:        0
            right:      0
            width:      100%
            height:     100%
            z-index:    9999
            cursor:     pointer

        .file-input-message
            margin-top: 25%
            text-align: center
            color:      #fff

        .main-image
            position:           relative
            overflow:           hidden
            max-height:         250px
            margin-bottom:      20px
            display:            flex
            flex-flow:          column
            justify-content:    center
            align-items:        center

            img
                width: 100%

            &.empty
                border: 1px dashed #fff

            &.gallery
                margin-bottom: 5px

            &:hover
                .nav-arrow
                    opacity: 1

        .nav-arrow
            position:   absolute
            cursor:     pointer
            z-index:    3
            opacity:    0
            transition: 0.5s

            &:before
                border-color:   #000
                border-style:   solid
                content:        ''
                display:        inline-block
                height:         20px
                width:          20px
                vertical-align: top

            &.right
                right:      15px
                transform:  rotate(45deg)

                &:before
                    border-width:   2px 2px 0 0

                &:hover
                    margin-right: -5px

            &.left
                left: 15px
                transform:  rotate(-45deg)

                &:before
                    border-width:   2px 0 0 2px

                &:hover
                    margin-left: -5px
</style>
