<template>
    <li>
        {{ pet.type !== 'Other' ? pet.type + ',' : '' }} {{ pet.type !== 'Other' ? pet.breed : pet.other_type }}, Age: {{ pet.age }}
    </li>
</template>

<script>
    export default {
        name: 'pet-display',

        props: {
            pet: {
                type: Object,
                required: true
            }
        }
    }
</script>
