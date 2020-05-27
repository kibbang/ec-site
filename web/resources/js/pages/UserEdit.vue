<template>
<div>
	<div>
	<h1>ユーザ更新</h1>
	<p>User Id: {{ user.id }}</p>
	<form @submit.prevent="updateUser">
		<div class="form-group">
			<label for="name">Name:</label>
			<input v-model="user.name">
		</div>
		<div class="form-group">
			<label for="email">Email:</label>
			<input v-model="user.email">
		</div>
		<button type="submit">更新</button>
	</form>
	</div>
</div>
</template>

<script>
	export default {
		data(){
			return {
				id: this.$route.params.id,
				user:{
					id:'',
					name: '',
					email:''
				}
			}
		},
		methods:{
			updateUser(){
				axios.put('/api/user/' + this.user.id,{
					user: this.user
				})
				.then(response => {
					this.user = response.data.user;
					this.$router.push({ name: 'user_detail' ,params :{ id: this.$route.params.id }})
				})
				.catch(error => console.log(error));
			},
		},
		created(){
			axios.get('/api/user/' + this.id)
			.then(response => this.user = response.data.user)
			.catch(erorr => console.log(error));
		}

	}
</script>