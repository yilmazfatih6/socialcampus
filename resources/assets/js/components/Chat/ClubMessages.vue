<template>
    <div class="container-fluid chat-log">

    </div>
</template>

<script>
  export default {
    props: ['messages']
  };
</script>

<style scoped>
.chat-log {
    overflow: scroll;
    overflow-x:hidden;
}
.message-box span{
    background-color: #fff;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 5px;
    display: block;
    border: 1px solid #e8ecef;
}
</style>
