 <template>
    <div class="vue-gallery">
        <div class="main-image"
             :class="[ { empty: cachedImages.length == 0 && !viewOnly }, { gallery: viewOnly }]"
             :style="'height: ' + height + '; width: ' + width" >
            <input type="file"
                   multiple
                   accept="image/jpeg, image/png, image/jpg"
                   class="file-input"
                   @change="cacheImages"
                   v-if="!viewOnly"/>
            <i class="nav-arrow left" v-if="viewOnly && cachedImages.length > 1" @click="goToPrevImage"></i>
            <div v-if="loading" class="loading-mask">
                <div class="loader" />
            </div>
            <img v-if="cachedImages.length > 0" :src="cachedImages[currentImageIdx].image" @click="click">
            <img v-else-if="viewOnly" @click="click" :style="'height: ' + height + '; width: ' + width" >
            <div v-else class="file-input-message">Drag / Click to Upload Images</div>
            <i class="nav-arrow right" v-if="viewOnly && cachedImages.length > 1" @click="goToNextImage"></i>
        </div>
        <div class="sub-gallery" v-if="!viewOnly && !single">
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
    import imageLoader from 'blueimp-load-image';
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

            clickFn: {
                type: Function
            },

            single: {
                type: Boolean,
                default: false
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
            currentImageIdx: 0,
            height: 0,
            loading: false,
            width: 0
        }),

        mounted() {
            if (this.images) {
                this.cachedImages = this.images;
            }

            this.calculateSize();
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
            async cacheImages(e) {
                this.loading = true;
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length) {
                    return;
                }

                if (this.single) {
                    this.createImage(files[0]);
                } else {
                    for (var i = 0; i < files.length; i++) {
                        await this.createImage(files[i]).then(e => {
                            if (this.single) {
                                this.cachedImages.splice(0, 1, {
                                    image: e.toDataURL(),
                                    idx: this.cachedImages.length
                                });
                            } else {
                                this.cachedImages.push({
                                    image: e.toDataURL(),
                                    idx: this.cachedImages.length
                                });
                            }
                        });
                    }
                }

                if (this.vuexSet) {
                    if (this.single) {
                        this.$store.commit(this.vuexSet, this.files[0]);
                    } else {
                        this.$store.commit(this.vuexSet, this.files);
                    }
                }
                this.loading = false;
            },

            calculateSize() {
                 var el = this.$el,
                    width = el.clientWidth,
                    height = el.clientHeight;

                this.width = width + 'px';

                if (this.single) {
                    this.height = width + 'px';
                } else {
                    this.height = width / 16 * 9 + 'px';
                }
            },

            createImage(file) {
                return new Promise(resolve => {
                    var image = new Image(),
                        reader = new FileReader();

                    this.files.push(file);
                    imageLoader(file,
                        resolve,
                        {
                            canvas: true,
                            orientation: true
                    });
                });
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

            click() {
                if (this.clickFn) {
                    this.clickFn();
                }
            },

            removePhoto(idx) {
                this.files.splice(idx, 1);
                this.cachedImages.splice(idx, 1);
                this.cachedImages.forEach((image, idx) => {
                    image.idx = idx;
                });
                this.setVuex();
                this.$emit('removePhoto', idx);
            },

            selectPhoto(idx) {
                this.currentImageIdx = idx;
            },

            setVuex() {
                if (this.vuexSet) {
                    if (this.single) {
                        this.$store.commit(this.vuexSet, this.files[0]);
                    } else {
                        this.$store.commit(this.vuexSet, this.files);
                    }
                }
            }
        },

        watch: {
            images(val) {
                val ? this.cachedImages = val : null;
            }
        }
    }
</script>

<style lang="sass" scoped>
    .vue-gallery
        font-family: "Roboto", sans-serif;

        .sub-gallery
            overflow:   hidden
            position:   relative

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
            cursor:     pointer

        .file-input-message
            text-align: center
            color:      #333

        .main-image
            position:           relative
            overflow:           hidden
            margin:             0px auto
            margin-bottom:      20px
            display:            flex
            flex-flow:          column
            justify-content:    center
            align-items:        center
            border-radius:      5px

            img
                width:  100%
                height: 100%
                cursor: pointer
                object-fit: contain
                border-radius: 5px

            &.empty
                background: #dddddd44

            &.gallery
                margin-bottom: 5px
                background: grey

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
                border-color:   #fff
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

    .loading-mask
        position:           absolute
        height:             100%
        width:              100%
        display:            flex
        justify-content:    center
        align-items:        center
        background:         rgba(255, 255, 255, 0.4)

    .loader
        border:         6px solid #f3f3f3 /* Light grey */
        border-top:     6px solid #444 /* Dark grey */
        border-radius:  50%
        width:          20px
        height:         20px
        animation:      spin 2s linear infinite

    @keyframes spin
        0%
            transform: rotate(0deg)
        100%
            transform: rotate(360deg)

    @media screen and (max-width: '956px')
        .vue-gallery
            .nav-arrow
                opacity: 1

                &.right
                    &:hover
                        margin-right: 0px

                &.left
                    &:hover
                        margin-left: 0px
</style>
