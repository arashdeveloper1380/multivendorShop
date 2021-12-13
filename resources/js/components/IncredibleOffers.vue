<template>
    <div>
        <table class="table table-bordered vertical-middle">
            <thead>
                <tr>
                    <th>ردیف</th>
                    <th>تصویر</th>
                    <th>عنوان محصول</th>
                    <th>فروشنده</th>
                    <th>گارانتی</th>
                    <th>رنگ</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item,key) in warrantyList.data">
                    <td class="vertical-middle">{{ getRow(key) }}</td>
                    <td class="vertical-middle"><img v-bind:src="$siteUrl+'upload/products/'+item.get_product.image_url" width="100px"></td>
                    <td class="vertical-middle">{{ item.get_product.title }}</td>
                    <td class="vertical-middle"></td>
                    <td class="vertical-middle">{{ item.get_warranty.name }}</td>
                    <td style="width:100px" class="vertical-middle">
                        <span v-bind:style="[item.get_color.id>0 ? {background:item.get_color.code} : {}]">
                            <span class="vue-color" v-if="item.get_color.id>0" v-bind:style="[item.get_color.name=='مشکی' ? {color:'white'} : {color:'black'}]">{{ item.get_color.name }}</span>
                        </span>
                    </td>
                    <td class="vertical-middle" style="width: 100px;">
                        <p class="select_item" v-on:click="show_box(item.id,key)">انتخاب</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <pagination :data="warrantyList" @pagination-change-page="getWarrantyList"></pagination>

        <div class="modal fade text-right" id="priceBox">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="close-moadal">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title">افزودن به لیست پیشنهاد شگقفت انگیز</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>هزینه محصول</label>
                            <input v-model="formInput.price1" class="form-control" name="price1"/>
                        </div>
                        <div class="form-group">
                            <label>هزینه محصول</label>
                            <input v-model="formInput.price2" class="form-control" name="price2"/>
                        </div>
                        <div class="form-group">
                            <label>تعداد موجودی محصول</label>
                            <input v-model="formInput.productNumber" class="form-control" name="productNumber"/>
                        </div>
                        <div class="form-group">
                            <label>تعداد سفارش</label>
                            <input v-model="formInput.product_number_cart" class="form-control" name="productNumberCart"/>
                        </div>
                        <div class="form-group">
                            <label>تاریخ شروع</label>
                            <input type="text" v-model="date1" id="pcal1" class="form-control pdate" />
                        </div>
                        <div class="form-group">
                            <label>تاریخ پایان</label>
                            <input type="text" v-model="date2" id="pcal2" class="form-control pdate" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" v-on:click="add()">افزودن</button>
                        <button type="button" class="btn btn-secondary" v-on:click="add()" data-dismiss="modal">انصراف</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div>
</template>

<script>
    export default {
        name: "incredible-offers",
        data(){
            return {
                warrantyList:{data:[]},
                page:1,
                formInput:{
                    price1:'',
                    price2:'',
                    product_number:'',
                    product_number_cart:''
                },
                date1:'',
                date2:'',
                select_key:-1,
                warranty_id:-1
            }
        },
        mounted(){
            this.getWarrantyList(1);
        },
        methods: {
            getWarrantyList:function(page){
                this.page = page;
                const url = this.$siteUrl+'/admin/ajax/getWarranty?page='+page;
                this.axios.get(url).then(response=>{
                   this.warrantyList = response.data;
                });
            },
            getRow:function (index){
                ++index;
                let k=(this.page-1)*10;
                k = k+index;
                return k;
            },
            show_box:function (item_id,key){
                $('#priceBox').modal('show');
                this.warranty_id=item_id;
                this.select_key=key;
                this.formInput.price1 = this.warrantyList.data[key].price1;
                this.formInput.price2 = this.warrantyList.data[key].price2;
                this.formInput.productNumber = this.warrantyList.data[key].productNumber;
                this.formInput.productNumberCart = this.warrantyList.data[key].productNumberCart;
            },
            add:function () {
                this.date1 = $('#pcal1').val();
                this.date1 = $('#pcal2').val();

                const formData = new formData();
                formData.appent('price1',this.formInput.price1);
                formData.appent('price2',this.formInput.price2);
                formData.appent('productNumber',this.formInput.productNumber);
                formData.appent('productNumberCart',this.formInput.productNumberCart);
                formData.appent('date1',this.date1);
                formData.appent('date2',this.date2);
                const url = this.siteUrl+"/admin/incredible-offers/"+this.warranty_id;

                this.axios.post().then(response=>{

                });
            }
        },
    }
</script>

<style scoped>

</style>