<template>
    <div class="container-fluid" style="margin: 0; padding: 0">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-left">Products</h3>

                <button type="button" class="btn btn-primary btn-sm float-right" @click="productModal">
                    <i class="fas fa-plus"></i>
                    Add Product
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <form class="form-inline my-2 my-lg-0 ml-auto mr-3" @submit.prevent="searchit">
                        <input v-model="search" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-dark my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-4" v-for="product in allProducts.data" :key="product.id">
                        <div class="card mb-3">
                            <div class="row no-gutters">
                                <div class="col-md-5">
                                    <div class="row justify-content-center">
                                        <img :src="getPhoto(product.image)" class="card-img mt-4" style="width: 100px">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body" style="padding: 20px">
                                        <h5 class="card-title">{{product.name}}</h5>
                                        <p>Number: {{product.productNumber}}</p>
                                        <p>Price: {{product.price}}</p>
                                        <p>
                                            <router-link :to="{path: '/product_details/' + product.productNumber}">
                                                <button type="button" class="btn btn-primary btn-sm">More</button>
                                            </router-link>
                                            <button type="button" class="btn btn-success btn-sm"
                                                    @click="editProduct(product)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                    @click="deleteProduct(product.id)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="add-product" :resizable="true" :clickToClose="false" height="auto" :scrollable="true">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 mb-3 mt-3">
                        <h4 v-if="!isEdit">Add Product</h4>
                        <h4 v-if="isEdit">Edit Product</h4>
                        <hr>
                        <form method="post" @submit.prevent="createProduct">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input v-model="form.name" type="text" name="name"
                                       placeholder="Enter Name"
                                       class="form-control">
                                <small style="color: red" v-if="error && errors.name">{{ errors.name[0] }}</small>
                            </div>
                            <div class="form-group">
                                <label>Quantity</label>
                                <input v-model="form.quantity" type="number" name="quantity"
                                       placeholder="Enter Quantity"
                                       class="form-control">
                                <small style="color: red" v-if="error && errors.quantity">{{ errors.quantity[0] }}
                                </small>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input v-model="form.price" type="number" name="price"
                                       placeholder="Enter Price"
                                       class="form-control">
                                <small style="color: red" v-if="error && errors.price">{{ errors.price[0] }}</small>
                            </div>
                            <div class="form-group" v-if="isEdit">
                                <label>Current Image</label><br>
                                <img :src="getPhoto(form.image)" class="card-img img-fluid" style="width: 100px">
                            </div>
                            <div class="form-group justify-content-center">
                                <label for="files" v-if="!isEdit">Select Image</label>
                                <label for="files" v-if="isEdit">Select to Change</label>
                                <input type="file" class="form-control-file" @change="fieldChange"
                                       id="files">
                                <small style="color: red" v-if="error && errors.files">{{ errors.files[0] }}</small>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea v-model="form.description" class="form-control" rows="4"></textarea>
                                <small style="color: red" v-if="error && errors.description">{{ errors.description[0] }}
                                </small>
                            </div>
                            <hr>
                            <button type="button" class="btn btn-danger btn-sm" @click="close">Close</button>
                            <button type="submit" class="btn btn-success btn-sm" v-if="!isEdit">Add Product</button>
                            <button type="button" class="btn btn-success btn-sm" v-if="isEdit" @click="updateProduct">
                                Update Product
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </modal>
        <div class="vld-parent">
            <loading name="loader" :active.sync="isLoading"
                     :can-cancel="false"
                     :is-full-page="fullPage"></loading>
        </div>
    </div>
</template>

<script>
    import {VueEditor} from "vue2-editor";
    // Import component
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        name: "Dashboard",
        components: {
            VueEditor,
            Loading
        },
        data() {
            return {
                isLoading: false,
                fullPage: true,
                isEdit: false,
                attachments: [],
                formProduct: new FormData(),
                errors: {},
                error: false,
                allProducts: {},
                search: '',
                form: new Form({
                    id: '',
                    name: '',
                    description: '',
                    quantity: '',
                    price: '',
                    image: ''
                })
            }
        },
        methods: {
            getPhoto(img) {
                let photo = "img/" + img;
                return photo;
            },
            searchit(){
                this.isLoading = true;
                let query = this.search;
                axios.get('/products/find_products/' + query)
                    .then((data) => {
                        this.allProducts = data.data;
                        this.isLoading = false;
                    })
            },
            deleteProduct(productId) {
                swal.fire({
                    title: 'Are you sure?',
                    text: "Delete this Product??",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete("/products/" + productId).then(() => {
                            Fire.$emit('entry');
                            swal.fire(
                                'Deleted!',
                                'Successfully Deleted!!',
                                'success'
                            )
                            Fire.$emit('entry');
                        }).catch(error => {
                            this.errors = error.response.data.errors;
                            swal.fire({
                                type: 'error',
                                title: 'Error!!',
                                text: error.response.data.msg,
                            })
                        });
                    }
                })
            },
            updateProduct() {
                this.isLoading = true;
                for (let i = 0; i < this.attachments.length; i++) {
                    this.formProduct.append('files[]', this.attachments[i]);
                }
                this.formProduct.append('name', this.form.name);
                this.formProduct.append('description', this.form.description);
                this.formProduct.append('quantity', this.form.quantity);
                this.formProduct.append('price', this.form.price);

                const config = {headers: {'Content-Type': 'multipart/form-data'}};

                axios.post('/products/update_product/' + this.form.id, this.formProduct, config).then(response => {
                    this.isLoading = false;
                    this.$modal.hide('add-product');
                    Fire.$emit('entry');
                    this.form.reset();
                    swal.fire({
                        type: 'success',
                        title: 'Success!!',
                        text: 'Product Updated Successfully',

                    })

                })
                    .catch(error => {
                        this.isLoading = false;
                        this.error = true;
                        this.errors = error.response.data.errors;
                    });
            },
            editProduct(product) {
                this.isEdit = true;
                this.errors = {};
                this.error = false;
                this.$modal.show('add-product');
                this.form.fill(product);
            },
            getProducts() {
                axios.get("/products").then(({data}) => ([this.allProducts = data]));
            },
            fieldChange(e) {
                let selectedFiles = e.target.files;
                if (!selectedFiles.length) {
                    return false;
                }
                for (let i = 0; i < selectedFiles.length; i++) {
                    this.attachments.push(selectedFiles[i]);
                }
            },
            close() {
                this.$modal.hide('add-product');
            },
            productModal() {
                this.isEdit = false;
                this.form.reset();
                $("#files").val('');
                this.errors = {};
                this.error = false;
                this.$modal.show('add-product');
            },
            createProduct() {
                this.isLoading = true;
                for (let i = 0; i < this.attachments.length; i++) {
                    this.formProduct.append('files[]', this.attachments[i]);
                }
                this.formProduct.append('name', this.form.name);
                this.formProduct.append('description', this.form.description);
                this.formProduct.append('quantity', this.form.quantity);
                this.formProduct.append('price', this.form.price);

                const config = {headers: {'Content-Type': 'multipart/form-data'}};

                axios.post('/products', this.formProduct, config).then(response => {
                    this.isLoading = false;
                    this.$modal.hide('add-product');
                    Fire.$emit('entry');
                    this.form.reset();
                    swal.fire({
                        type: 'success',
                        title: 'Success!!',
                        text: 'Product Created Successfully',

                    })

                })
                    .catch(error => {
                        this.isLoading = false;
                        this.error = true;
                        this.errors = error.response.data.errors;
                    });
            }
        },
        created() {
            this.getProducts();
            Fire.$on('entry', () => {
                this.getProducts();
            })
        }
    }
</script>

<style scoped>

</style>