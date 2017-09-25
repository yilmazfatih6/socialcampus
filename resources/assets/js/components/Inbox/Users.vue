<template>
	<div class="row">
		<div v-for="user in users">
			<div class="userblock">
				<inbox-user :user="user"></inbox-user>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['users'],
	}
</script>

<style scoped>
	.userblock {
		padding: 0 20px 0 20px;
	}
</style>
