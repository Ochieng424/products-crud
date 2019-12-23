<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-left">Products</h3>

                <button type="button" class="btn btn-primary btn-sm float-right" @click="productModal">Add Product
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4" v-for="product in allProducts.data" :key="product.id">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row no-gutters">
                                <div class="col-md-4" style="padding-left: 20px;">
                                    <img :src="product.image" class="card-img img-fluid" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">{{product.name}}</h5>
                                        <p>Price: {{product.price}}</p>
<!--                                        <p><small class="text-muted">{{product.created_at|myDate}}</small></p>-->
                                        <p>
                                            <button type="button" class="btn btn-primary btn-sm">More</button>
                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm">
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
                        <h4>Add Product</h4>
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
                            <div class="form-group justify-content-center">
                                <label for="files">Select Image</label>
                                <input type="file" class="form-control-file" @change="fieldChange"
                                       id="files">
                                <small style="color: red" v-if="error && errors.files">{{ errors.files[0] }}</small>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea v-model="form.description" class="form-control" rows="3"></textarea>
                                <small style="color: red" v-if="error && errors.description">{{ errors.description[0]
                                    }}
                                </small>
                            </div>
                            <hr>
                            <button type="button" class="btn btn-danger btn-sm" @click="close">Close</button>
                            <button type="submit" class="btn btn-success btn-sm">Add Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
    import {VueEditor} from "vue2-editor";

    export default {
        name: "Dashboard",
        components: {
            VueEditor
        },
        data() {
            return {
                attachments: [],
                formProduct: new FormData(),
                errors: {},
                error: false,
                allProducts: {},
                form: new Form({
                    name: '',
                    description: '',
                    quantity: '',
                    price: ''
                })
            }
        },
        methods: {
            getProducts() {
                axios.get("/product/get_products").then(({data}) => ([this.allProducts = data]));
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
                this.form.reset();
                $("#files").val('');
                this.errors = {};
                this.error = false;
                this.$modal.show('add-product');
            },
            createProduct() {
                for (let i = 0; i < this.attachments.length; i++) {
                    this.formProduct.append('files[]', this.attachments[i]);
                }
                this.formProduct.append('name', this.form.name);
                this.formProduct.append('description', this.form.description);
                this.formProduct.append('quantity', this.form.quantity);
                this.formProduct.append('price', this.form.price);

                const config = {headers: {'Content-Type': 'multipart/form-data'}};

                axios.post('/product/create_product', this.formProduct, config).then(response => {
                    this.$modal.hide('add-product');
                    Fire.$emit('entry');
                    this.form.reset();
                    Swal.fire({
                        type: 'success',
                        title: 'Submited!!',
                        text: 'Successfully',

                    })

                })
                    .catch(error => {
                        this.error = true;
                        this.errors = error.response.data.errors;
                    });
            }
        },
        created() {
            this.getProducts();
        }
    }
</script>

<style scoped>

</style>