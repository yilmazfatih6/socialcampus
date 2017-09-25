<template>
    <div class="input-group">
        <input id="btn-input" type="text" name="message" class="form-control" placeholder="Mesaj yaz..." v-model="newMessage" @keyup.enter="sendMessage">

        <span class="input-group-btn">
            <button class="btn btn-info" id="btn-chat" @click="sendMessage">
                <i class="fa fa-paper-plane" aria-hidden="true"></i>
            </button>
        </span>
    </div>
</template>

<script>
    export default {
        props: ['user'],

        data() {
            return {
                newMessage: ''
            }
        },

        methods: {
            sendMessage() {
                this.$emit('messagesent', {
                    user: this.user,
                    message: this.newMessage
                });

                this.newMessage = ''
            }
        }
    }
</script>

<style scoped>
    .input-group {
        margin-bottom: 25px;
    }
    .input-group button, .input-group input{
        border-radius: 0px;
    }
</style>
