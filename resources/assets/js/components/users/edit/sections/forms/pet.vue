<template>
    <div class="pet-form">
        <div class="pet-form-header">
            {{ idx + 1}}.
            <div class="text-btn" @click="removePet">&times;</div>
        </div>
        <div class="row marginless">
          <div class="xs-1-2">
            <div class="form-group">
                <label for="pet-type">Type<sup v-if="hasError(errorStart + '.type')" class="form-errors">*</sup></label>
                <v-select class="form-control single full-width"
                          name="pet-type"
                          v-model="pet.type"
                          :options="typeOptions"
                          :searchable="false"
                          :clearable="false">
                </v-select>
            </div>
          </div>
          <div class="xs-1-2">
            <div class="form-group">
                <label for="pet-age">Age<sup v-if="hasError(errorStart + '.age')" class="form-errors">*</sup></label>
                <input
                    class="form-control full-width"
                    type="text"
                    name="pet-age"
                    placeholder="e.g. 10"
                    v-model="pet.age"
                    @input="removeError(errorStart + '.age', $event)"
                />
            </div>
          </div>
        </div>
        <div class="row marginless">
          <div v-if="pet.type !== 'Other'" class="xs-1-2">
            <div class="form-group">
                <label for="pet-breed">Breed<sup v-if="hasError(errorStart + '.breed')" class="form-errors">*</sup></label>
                <input
                    class="form-control full-width"
                    type="text"
                    name="pet-breed"
                    :placeholder="pet.type === 'Dog' ? 'e.g. Great Dane' : 'e.g. Siamese'"
                    v-model="pet.breed"
                    @input="removeError(errorStart + '.breed', $event)"
                />
            </div>
          </div>
          <div v-else class="xs-1-2">
            <div class="form-group">
                <label for="pet-other-type">What is it?<sup v-if="hasError(errorStart + '.other_type')" class="form-errors">*</sup></label>
                <input
                    class="form-control full-width"
                    type="text"
                    name="pet-other-type"
                    placeholder="e.g. Rabbit"
                    v-model="pet.other_type"
                    @input="removeError(errorStart + '.other_type', $event)"
                />
            </div>
          </div>
        </div>
        <div class="form-errors" v-if="errorExists()">
            <sup>*</sup>Please Complete Required Fields
        </div>
    </div>
</template>

<script>
    import ErrorMixins from '../../../../../mixins/errorMixins';

    export default {
        name: 'pet-form',

        mixins: [ ErrorMixins ],

        props: {
            idx: {
                type: Number,
                required: true
            },

            pet: {
                required: true
            }
        },

        data: () => ({
            errorModel: 'users',
            typeOptions: [
              'Cat',
              'Dog',
              'Other'
            ]
        }),

        computed: {
            errorStart() { return 'pets.' + this.idx }
        },

        methods: {
            errorExists() {
                return this.hasError(this.errorStart + '.type') ||
                  this.hasError(this.errorStart + '.age') ||
                  this.hasError(this.errorStart + '.breed') ||
                  this.hasError(this.errorStart + '.other_type');
            },

            removePet() {
                this.$store.commit('users/removePet', this.idx);
            }
        }
    }
</script>
