<template>
    <div class="container-fluid" style="margin: 0; padding: 0">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link :to="{path: '/dashboard'}">All Products</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">{{details.productNumber}}</li>
            </ol>
        </nav>
        <h2>Product Details</h2>
        <hr>
        <div class="row">
            <div class="col-sm-5">
                <div class="row">
                    <img :src="getPhoto(details.image)" class="card-img img-fluid mx-auto" style="width: 400px;">
                </div>
            </div>
            <div class="col-sm-7">
                <h3>{{details.name}}</h3>
                <p><small class="text-muted">{{details.created_at|myDate}}</small></p>
                <hr>
                <p>Quantity: {{details.quantity}}</p>
                <b style="font-size: 20px;">Ksh {{details.price}}</b>
                <hr>
                <h4 style="text-decoration: underline;">Description</h4>
                <p>{{details.description}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ProductDetails",
        data(){
            return{
                productNo: this.$route.params.productNo,
                details: {}
            }
        },
        methods:{
            getPhoto(img) {
                let photo = "img/" + img;
                return photo;
            },
            getDetails(){
                axios.get("/product/get_details/" + this.productNo).then(({data}) => ([this.details = data]));
            }
        },
        created() {
            this.getDetails();
        }
    }
</script>

<style scoped>

</style>