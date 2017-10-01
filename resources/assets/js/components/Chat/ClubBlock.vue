<template>
	<div class="media">
		<div class="media-left">
			<img :src="src+club.avatar"/>
		</div>
		<div class="media-body">
			<span>{{club.name}}</span>
		</div>
	</div>
</template>

<script>
	export default {
		 props: ['club'],
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
		padding: 10px;
		border: 1px solid #e8ecef;
	}
	.media img {
		border-radius: 100%;
		width: 50px;
		height: 50px;
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
