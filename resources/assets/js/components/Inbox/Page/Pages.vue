<template>
	<div class="row">
		<div v-for="page in pages">
			<div class="eventblock">
				<inbox-page :user="user" :page="page"></inbox-page>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['pages', 'user'],
	}
</script>

<style scoped>
	.eventblock {
		padding: 0 20px 0 20px;
	}
</style>
