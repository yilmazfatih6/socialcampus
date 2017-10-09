<template>
	<div class="row">
		<div v-for="club in clubs">
			<div class="clubblock">
				<inbox-club :user="user" :club="club"></inbox-club>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['clubs', 'user'],
	}
</script>

<style scoped>
	.clubblock {
		padding: 0 20px 0 20px;
	}
</style>
