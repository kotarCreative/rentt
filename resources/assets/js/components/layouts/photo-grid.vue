<template>
    <div class="image-uploader__grid">
        <div class="image-uploader__grid-row">
            <photo :image="images[0]" index="0"></photo>
            <photo :image="images[1]" index="1"></photo>
            <photo :image="images[2]" index="2"></photo>
        </div>
        <div class="image-uploader__grid-row">
            <photo :image="images[3]" index="3"></photo>
            <photo :image="images[4]" index="4"></photo>
            <photo :image="images[5]" index="5"></photo>
        </div>
        <div class="image-uploader__grid-row">
            <photo :image="images[6]" index="6"></photo>
            <photo :image="images[7]" index="7"></photo>
            <photo :image="images[8]" index="8"></photo>
        </div>
    </div>
</template>

<script>
    import Photo from './photo';

    export default {
        name: 'image-grid',

        components: {
            Photo
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

</style>