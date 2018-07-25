<template>
    <div class="loader"></div>
</template>

<style lang="sass">
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
</style>
