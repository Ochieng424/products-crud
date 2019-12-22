<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 ml-auto mr-auto mt-4" style="background-color: #f4f4f4; padding: 20px">
                <h4>Login</h4>
                <form>
                    <div class="form-group">
                        <label>Email</label>
                        <input v-model="form.email" type="email" name="email"
                               placeholder="Email"
                               class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email"></has-error>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input v-model="form.password" type="password" name="password"
                               placeholder="Password"
                               class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password"></has-error>
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
        data(){
            return{
                form: new Form({
                    email: '',
                    password: ''
                })
            }
        }
    }
</script>

<style scoped>

</style>