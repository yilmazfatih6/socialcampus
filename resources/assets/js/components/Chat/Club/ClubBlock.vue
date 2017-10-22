<template>
	<div class="wrapper">
		<div v-if="admin">
			<a :href="'/club/'+club.abbreviation">
				<div class="pull-left"  style="line-height:10vh;">
					<a href="/chat" class="inline"><i class="fa fa-arrow-left inline" aria-hidden="true"></i></a>
					<img class="image inline" :src="src+club.avatar"/>
				</div>
			</a>
			<div class="name" style="line-height:10vh;">
				<a :href="'/club/'+club.abbreviation">
					<span>{{club.name}}</span>
				</a>
				<div class="pull-right">
					<a><i class="fa fa-arrows-h fix-chat" aria-hidden="true"></i></a>
					<a><i class="fa fa-arrow-up scroll-to-nav right-arrows" aria-hidden="true"></i></a>
				</div>
			</div>
		</div>
		<div v-else>
			<a :href="'/user/'+user.username">
				<div class="pull-left"  style="line-height:10vh;">
					<a href="/chat" class="inline"><i class="fa fa-arrow-left inline" aria-hidden="true"></i></a>
					<img class="image inline" :src="src+user.avatar"/>
				</div>
			</a>
			<div class="name" style="line-height:10vh;">
				<a :href="'/user/'+user.username">
					<span>{{user.first_name}} {{user.last_name}}</span>
				</a>
				<div class="pull-right">
					<a><i class="fa fa-arrows-h fix-chat" aria-hidden="true"></i></a>
					<a><i class="fa fa-arrow-up scroll-to-nav right-arrows" aria-hidden="true"></i></a>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		 props: ['club', 'admin' , 'user'],
		 data() {
            return {
                src: '/storage/avatars/',
            }
        },
	}
</script>

<style scoped>
	.wrapper {
		margin-top: -5px;
		background-color: #fff;
		padding: 15px;
		border: 1px solid #e8ecef;
		height: 14vh;
	}
	.image {
		border-radius: 100%;
		width: 50px;
		height: 50px;
		display: inline;
		margin: 0 10px 0 15px;
	}
	.name {
		padding-left: 20px;
		line-height: 50px;
		color: #636b6f;
		text-decoration: none;
		margin-left: 10px;
	}
	a, a:hover {
		text-decoration: none;
		color: #40c4ed;
	}
	.right-arrows {
		margin-left: 10px;
	}
</style>
