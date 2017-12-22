 <template>
    <div>
        <input type="file"
               multiple
               accept="image/jpeg, image/png, image/jpg"
               class="file-input"
               @change="cacheImages"/>
        <div class="sub-gallery">
            <photo v-for="(image, idx) in cachedImages" :image="image" :index="idx" @removePhoto="removePhoto(idx)"></photo>
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
            cachedImages: []
        }),

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
            }
        }
    }
</script>
