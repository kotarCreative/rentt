<template>
    <div id="feedback-form">
        <div v-if="notice" class="alert success">
            {{ notice }}
        </div>
        <div v-if="hasErrors()" class="alert warning">
            Please complete required fields
        </div>
        <div class="row">
            <div class="xs-1-1 sm-1-4">
                <div class="form-group">
                    <label for="name">Name<sup v-if="hasError('name')" class="form-errors">*</sup></label>
                    <input
                        class="form-control full-width"
                        :class="{ 'has-error': hasError('name') }"
                        type="text"
                        name="name"
                        placeholder="Mary Shelley"
                        v-model="name"
                        @input="removeError('name', $event)"
                    />
                </div>
            </div>
            <div class="xs-1-1 sm-1-4">
                <div class="form-group">
                    <label for="issue">Issue<sup v-if="hasError('issue')" class="form-errors">*</sup></label>
                    <v-select class="form-control full-width single"
                              :class="{ 'has-error': hasError('issue') }"
                              name="issue"
                              v-model="issue"
                              label="name"
                              :clearable="false"
                              :searchable="false"
                              @input="removeError('issue', $event)"
                              :options="issueTypes">
                    </v-select>
                </div>
            </div>
            <div class="xs-1-1 sm-1-4">
                <div class="form-group">
                    <label>Would you like a response?</label>
                    <v-checkbox v-model="respond"
                                name="respond"
                                :options="responses"
                                type="radio">
                        <span slot="label" slot-scope="{ option }">{{ option.label }}</span>
                    </v-checkbox>
                </div>
            </div>
            <div v-if="respond == 'yes'" class="xs-1-1 sm-1-4">
                <div class="form-group">
                    <label for="email">Email<sup v-if="hasError('email')" class="form-errors">*</sup></label>
                    <input
                        class="form-control full-width"
                        :class="{ 'has-error': hasError('email') }"
                        type="text"
                        name="email"
                        placeholder="mary@rentt.io"
                        v-model="email"
                        @input="removeError('email', $event)"
                    />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="sm-1-1">
                <div class="form-group">
                    <label for="comments">Comments<sup v-if="hasError('comments')" class="form-errors">*</sup></label>
                    <div class="text-area">
                        <textarea
                            class="form-control"
                            :class="{ 'has-error': hasError('comments') }"
                            v-model="comments"
                            maxlength="1000"
                            placeholder="Write your comments here..."
                            @input="removeError('comments', $event)"></textarea>
                        <span class="word-count">{{ 1000 - comments.length }}</span>
                    </div>
                </div>
                <div class="modal-actions">
                    <button class="btn" @click="submit">Send</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ErrorMixins from '../../mixins/errorMixins';

    export default {
        name: 'feedback-form',

        mixins: [ErrorMixins],

        data: _ => ({
            errorModel: 'feedback',
            email: null,
            name: null,
            issue: 'Unsure',
            issueTypes: [
                'Unsure',
                'Bug',
                'Improvement',
                'Addition',
                'Report User/Listing'
            ],
            comments: '',
            respond: 'no',
            responses: [
                {
                    val: 'no',
                    label: 'No'
                },
                {
                    val: 'yes',
                    label: 'Yes'
                }
            ]
        }),

        computed: {
            notice() {
                return this.$store.getters.notices('feedback');
            }
        },

        methods: {
            submit() {
                var data = {
                    name: this.name,
                    issue: this.issue,
                    comments: this.comments,
                    respond: this.respond
                };

                this.respond === 'yes' ? data.email = this.email : null;

                this.$store.dispatch('sendFeedback', data);
            }
        }
    }
</script>
