<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 ml-auto mr-auto mt-4" style="background-color: #f4f4f4; padding: 20px">
                <h4>Login</h4>
                <form method="post" @submit.prevent="login">
                    <div class="form-group">
                        <label>Email</label>
                        <input v-model="email" type="email" name="email"
                               placeholder="Email"
                               class="form-control">
                        <small style="color: red" v-if="error && errors.email">{{ errors.email }}</small>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input v-model="password" type="password" name="password"
                               placeholder="Password"
                               class="form-control">
                        <small style="color: red" v-if="error && errors.password">{{ errors.password }}</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data() {
            return {
                errors: {},
                error: false,
                success: false,
                email: '',
                password: ''
            }
        },
        methods: {
            login() {
                this.$auth.login({
                    params: {
                        email: this.email,
                        password: this.password,
                    },
                    success: function () {
                    },
                    error: function (resp) {
                        this.error = true;
                        this.errors = resp.response.data.errors;
                    },
                    rememberMe: true,
                    redirect: '/dashboard',
                    fetchUser: true,
                });
            }
        }
    }
</script>

<style scoped>

</style>