<template>
    <div class="w-25">
        <input v-model="login" type="text" class="form-control mt-3 mb-3" placeholder="Логин">
        <input v-model="password" type="password" class="form-control mb-3" placeholder="Пароль">
        <input @click.prevent="logIn" type="submit" class="btn btn-primary" value="Войти">
    </div>
</template>

<script>
    import router from "@/router.js";

    export  default {
        data() {
            return {
                login: null,
                password: null
            }
        },
        methods: {
            logIn() {
                axios.post('/api/auth/login', {login: this.login, password: this.password})
                    .catch(function (error) {
                        if (error.response.status === 401) {
                            alert('Неправильный логин или пароль');
                            return false;
                        }
                    })
                    .then(res => {
                        if (res.status === 200) {
                            localStorage.api_token = res.data.data.api_token;
                            router.push({ path: '/dashboard' })
                        }
                    })
            }
        }
    }
</script>
