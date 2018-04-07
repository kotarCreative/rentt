<template>
    <div class="reference-wrapper">
        <div class="reference-user">
            {{ reference.first_name }} {{ reference.last_name }}
        </div>
        <div class="reference-relation">
            <b>Relation:</b> {{ reference.relationship.capitalizeAll() }}
        </div>
        <button class="btn primary">
            Contact Reference
        </button>
    </div>
</template>

<script>
    export default {
        name: 'reference-display',

        props: {
            reference: {
                type: Object,
                required: true
            }
        }
    }
</script>
