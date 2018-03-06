<template>
    <div class="v-select-wrapper">
        <i ref="openIndicator" role="presentation" class="open-indicator"></i>
        <slot name="spinner">
            <div class="spinner"></div>
        </slot>
    </div>
</template>

<script>

</script>

<style lang="sass">
    .v-select-wrapper
        .open-indicator
            position:                   absolute
            bottom:                     6px
            right:                      10px
            display:                    inline-block
            cursor:                     pointer
            pointer-events:             all
            transition:                 all 150ms cubic-bezier(1.000, -0.115, 0.975, 0.855)
            transition-timing-function: cubic-bezier(1.000, -0.115, 0.975, 0.855)
            opacity:                    1
            height:                     20px
            width:                      10px

            &:before
                border-color:               rgba(60, 60, 60, .5)
                border-style:               solid
                border-width:               3px 3px 0 0
                content:                    ''
                display:                    inline-block
                height:                     10px
                width:                      10px
                vertical-align:             top
                transform:                  rotate(133deg)
                transition:                 all 150ms cubic-bezier(1.000, -0.115, 0.975, 0.855)
                transition-timing-function: cubic-bezier(1.000, -0.115, 0.975, 0.855)
                box-sizing:                 inherit

        &.open
            .open-indicator
                bottom: 1px

                &:before
                    transform: rotate(315deg)

        &.loading
            .open-indicator
                opacity: 0

            .spinner
                opacity: 1

        .spinner
            opacity:        0
            position:       absolute
            top:            5px
            right:          10px
            font-size:      5px
            text-indent:    -9999em
            overflow:       hidden
            border-top:     .9em solid rgba(100, 100, 100, .1)
            border-right:   .9em solid rgba(100, 100, 100, .1)
            border-bottom:  .9em solid rgba(100, 100, 100, .1)
            border-left:    .9em solid rgba(60, 60, 60, .45)
            transform:      translateZ(0)
            animation:      vSelectSpinner 1.1s infinite linear
            transition:     opacity .1s

            &:after
                border-radius:  50%
                width:          5em
                height:         5em

    @-webkit-keyframes vSelectSpinner
        0%
            transform: rotate(0deg)

        100%
            transform: rotate(360deg)


    @keyframes vSelectSpinner
        0%
            transform: rotate(0deg)

        100%
            transform: rotate(360deg)
</style>
