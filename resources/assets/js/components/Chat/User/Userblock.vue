<template>
	<div class="media">
		<div class="media-left">
			<a href="/chat" class="inline"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
			<img :src="src+user.avatar"/>
		</div>
		<div class="media-body">
			<span>{{user.first_name}} {{user.last_name}}</span>
		</div>
	</div>
</template>

<script>
	export default {
		 props: ['user'],
		 data() {
            return {
                src: '/storage/avatars/'
            }
        },
	}
</script>

<style scoped>
	.media {
		margin-top: -5px;
		background-color: #fff;
		padding: 15px;
		border: 1px solid #e8ecef;
	}
	.media img {
		border-radius: 100%;
		width: 50px;
		height: 50px;
		display: inline;
	}
	.media-body span {
		line-height: 50px;
		color: #636b6f;
		text-decoration: none;
		margin-left: 10px;
	}
	a, a:hover {
		text-decoration: none;
	}
</style>
