<template>
    <div class="w-25">
        <input v-model="login" type="text" class="form-control mt-3 mb-3" placeholder="Логин">
        <input v-model="password" type="password" class="form-control mb-3" placeholder="Пароль">
        <input v-model="password_confirmation" type="password" class="form-control mb-3" placeholder="Повторите пароль">
        <input @click.prevent="store" type="submit" class="btn btn-primary" value="Зарегистрироваться">
    </div>
</template>

<script>
    export default {
        data() {
            return {
                login: null,
                password: null,
                password_confirmation:null
            }
        },
        methods: {
            store() {
                axios.post('/api/auth/registration', {
                    login: this.login,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                })
                    .then(res => {
                        console.log(res)
                    })
            }
        }
    }
</script>
