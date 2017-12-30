 <template>
    <div id="vue-gallery">
        <div class="main-image">
            <input type="file"
                   multiple
                   accept="image/jpeg, image/png, image/jpg"
                   class="file-input"
                   @change="cacheImages"/>
            <img v-if="cachedImages.length > 0" :src="cachedImages[currentImageIdx]">
            <span v-else>Drag or Click to Upload Images</span>
        </div>
        <div class="sub-gallery">
            <photo v-if="cachedImages.length > 3" :image="prevImage" :index="1" id="prev"></photo>
            <photo v-for="(image, idx) in visibleImages"
                   :image="image"
                   :index="idx"
                   @removePhoto="removePhoto(idx)"
                   @selectPhoto="selectPhoto(idx)"></photo>
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
            currentImageIdx: 0,
            position: 0
        }),

        computed: {
            prevImage() {
                var idx = this.currentImageIdx - 1;
                if (idx > 0) {
                    return this.cachedImages[idx];
                } else {
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
                } else {
                    return this.cachedImages[0];
                }
            },

            visibleImages() {
                return this.cachedImages.slice(this.position, this.position + 3);
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
                reader.onloadend = (e) => { this.cachedImages.push(reader.result) }

                reader.readAsDataURL(file);
            },

            removePhoto(idx) {
                this.files.splice(idx, 1);
                this.cachedImages.splice(idx, 1);
            },

            selectPhoto(idx) {
                idx > 0 ? this.position = idx - 1 : this.position  = 0;
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
