<template>
	<div class="row">
		<div v-for="event in events">
			<div class="eventblock">
				<inbox-event :user="user" :event="event"></inbox-event>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['events', 'user'],
	}
</script>

<style scoped>
	.eventblock {
		padding: 0 20px 0 20px;
	}
</style>
