<template>
	<a :href="'/chat/'+user.id+'/club/'+club.id">
		<div class="media">
			<div class="media-left">
				<img :src="src+club.avatar"/>
			</div>
			<div class="media-body">
				<span>{{club.name}}</span>
			</div>
		</div>
	</a>
</template>

<script>
	export default {
		 props: ['club', 'user'],
		 data() {
            return {
                src: '/storage/avatars/'
            }
        },
	}
</script>

<style scoped>
	.media {
		padding-bottom: 10px;
	}
	.media img {
		border-radius: 100%;
		width: 80px;
		height: 80px;
	}
	.media-body span {
		margin-left: 20px;
		line-height: 80px;
		color: #636b6f;
		text-decoration: none;
	}
	a, a:hover {
		text-decoration: none;
	}
</style>
