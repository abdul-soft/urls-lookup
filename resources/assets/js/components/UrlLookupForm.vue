<template>

    <div class="input-group">
        <input id="btn-input" type="text" name="urls" class="form-control input-sm"
               placeholder="Type Urls Comma seperated..." v-model="newUrls" @keyup.enter="sendUrls">

        <span class="input-group-btn">
            <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendUrls">
                Submit
            </button>
        </span>
    </div>

</template>

<script>
    export default {
        props: ['user'],

        data() {
            return {
                newUrls: ""
            }
        },

        methods: {
            sendUrls() {
                this.$emit('urlsent', {
                    urls: this.newUrls
                });

            }
        }
    }
</script>
