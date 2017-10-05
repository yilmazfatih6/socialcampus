<template>
    <div class="container-fluid chat-log">
        <div v-show="empty" class="empty text-center">
            <small>Henüz mesaj yok.</small>
        </div>
        
        <div v-for="message in messages">
            <!--Auth User Interface-->
            <div v-if="authId === userId">
                <div v-if="userId === message.receiver_id" class="row message-box">
                    <div class="pull-left">
                        <span v-text="message.message"></span>
                        <small class="text-danger" v-text="message.sender_name"></small>
                    </div>
                </div>
                <div v-if="userId === message.sender_id" class="row message-box">
                    <div class="pull-right">
                        <span v-text="message.message"></span>
                    </div>
                </div>
            </div>
            <!--Club Admin Interface-->
            <div v-else>
                <div v-if="userId === message.receiver_id" class="row message-box">
                    <div class="pull-right">
                        <span v-text="message.message"></span>
                        <small class="text-danger" v-text="message.sender_name"></small>
                    </div>
                </div>
                <div v-if="userId === message.sender_id" class="row message-box">
                    <div class="pull-left">
                        <span v-text="message.message"></span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
  export default {
    props: ['messages', 'userId', 'authId', 'empty']
  };
</script>

<style scoped>
.chat-log {
    overflow: scroll;
    overflow-x:hidden;
}
.empty {
    margin: 25px 0;
}
.message-box{
    background-color: #fff;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 5px;
    border: 1px solid #e8ecef;
}
.message-box span {
    display: block;
}
</style>
