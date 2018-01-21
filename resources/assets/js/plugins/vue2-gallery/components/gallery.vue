 <template>
    <div id="vue-gallery">
        <div class="main-image">
            <input type="file"
                   multiple
                   accept="image/jpeg, image/png, image/jpg"
                   class="file-input"
                   @change="cacheImages"/>
            <img v-if="cachedImages.length > 0" :src="cachedImages[currentImageIdx].image">
            <span v-else>Drag or Click to Upload Images</span>
        </div>
        <div class="sub-gallery">
            <photo v-if="cachedImages.length > 3" :image="prevImage" :index="1" id="prev"></photo>
            <photo v-for="image in visibleImages"
                   :image="image.image"
                   :index="image.idx"
                   @removePhoto="removePhoto(image.idx)"
                   @selectPhoto="selectPhoto(image.idx)"></photo>
            <photo v-if="cachedImages.length > 3" :image="nextImage" :index="1" id="next"></photo>
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

        data: () => ({
            files: [],
            cachedImages: [],
            currentImageIdx: 0
        }),

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
                    this.showLoader = false;
            },

            createImage(file) {
                var image = new Image();
                var reader = new FileReader();

                this.files.push(file);
                reader.onloadend = (e) => { this.cachedImages.push({ image: reader.result, idx: this.cachedImages.length }) }

                reader.readAsDataURL(file);
            },

            removePhoto(idx) {
                this.files.splice(idx, 1);
                this.cachedImages.splice(idx, 1);
            },

            selectPhoto(idx) {
                this.currentImageIdx = idx;
            }
        }
    }
</script>

<style lang="sass" scoped>
    .sub-gallery
        overflow: hidden
        position: relative

    #prev
        position: absolute
        left: - 33%

    #next
        position: absolute
        right: -33%
</style>
