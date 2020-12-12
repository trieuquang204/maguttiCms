<template>
    <div>
        <h3>Contatti</h3>
        <div class="card  p-3 border border-dark">
            <form v-on:submit.prevent>
                <div class="form-row w-100 my-3">
                    <ul class="ist-group list-group-horizontal list-group-item ml-auto border-0 px-0">
                        <li v-for="(value, key) in lang" :key="'lang_'+key" class="list-inline-item  py-1 px-2"
                            v-bind:class="{'bg-primary text-white':(curLang===key)}"
                            @click="changeLang(key)">{{ value }}
                        </li>
                    </ul>
                </div>
                <div class="form-row bg">
                    <select-component
                        label="Template" :options="templates"
                        :selected-option.sync="item.template_id">
                    </select-component>
                    <select-component
                            label="products" :options="products"
                            :selected-option.sync="item.product_id">
                    </select-component>

                    <input-component
                        class="mb-1 mr-sm-2 col-1"
                        :content.sync="item.id"
                        placeholder="Item Id" v-show="isEdit"/>
                    <input-component
                        label="Title"
                        :content.sync="item['title']"
                        placeholder="Enter a title"
                        v-show="this.curLang=='en'"/>
                    <input-component v-for="(value, key) in lang" :key="'input_'+key"
                        :label="'Title '+value"
                        :content.sync="item['title_'+key]"
                        :placeholder="'Enter a title  for '+value"
                        v-show="curLang==key"
                        v-if="defaultLang!=key"/>

                    <div class="form-group col-md-12" v-show="this.curLang=='en'">
                        <label for="description">Description</label>
                        <editor id="description" v-model="item.description"></editor>
                    </div>
                    <div class="form-group col-md-12"
                         v-for="(value, key) in lang" :key="'description_'+key"
                         v-show="curLang==key"
                         v-if="defaultLang!=key"
                    >
                        <label :for="'description_'+key">Description {{ value }}</label>
                        <editor :id="'description_'+key" v-model="item['description_'+key]"></editor>
                    </div>
                    <input-component label="Link" :content.sync="item.link" placeholder="Enter a link"
                                     class="col-lg-12"/>
                </div>


                <div class="row form-group">
                    <div class="col-12">
                        <label for="Image File Manager">Image File Manager</label>
                        <input id="image_media_id" name="image_media_id"
                               ref="image_media_id"
                               type="hidden 1" v-model="item.image" class=" form-control ">
                        <div class="media-cont">
                            <div class="media-input">
                                <a href="#" data-input="image_media_id" class="btn btn-default filemanager-select">
                                    <i class="fas fa-upload "></i> Upload file
                                </a></div>
                            <div :id="'box_image_'+item.id" class="media-saved">
                                <div>
                                    <a :href="item.image_url" target="_blank">
                                    <img :src="item.image_url" class="img-thumb pull-right">
                                </a>
                                </div>
                                <a id="delete-image_media_id-1" data-locale="" href="#" rel="tooltip"
                                   data-original-title="Delete this item" onclick="window.Cms.deleteImages(this)"
                                   class="btn btn-danger media-delete"><i class="fas fa-trash "></i></a></div>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <input-component :type="'number'" label="Sort" :content.sync="item.sort" class="col-lg-1"/>
                    <input-boolean-component :type="'hidden'" label="Status" :content.sync="item.pub" class="col-lg-1"/>
                </div>


                <div class="form-row bg">
                    <div class="form-group col-md-12">
                        <button v-if="isEdit==false" @click.prevent="addItem" class="btn btn-success mb-2 btn-block"><i
                                class="fas fa-plus"></i> Add
                        </button>
                        <button v-else="isEdit==true" @click.prevent="updateItem" class="btn btn-danger mb-2 w-100"><i
                                class="fas fa-edit"></i> Update
                        </button>
                    </div>
                </div>
            </form>
            <hr/>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                    <tr>
                        <td>Id</td>
                        <td>Image</td>
                        <td>Title</td>
                        <td>Link</td>
                        <td>Template</td>
                        <td>Note</td>
                        <td>Sort</td>
                        <td>Status</td>
                        <td>Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,index) in list">
                        <td>{{ item.id }}</td>
                        <td>{{ item.image_url }}</td>
                        <td>{{ item.title }}</td>
                        <td>{{ item.link }}</td>
                        <td>{{ item.template}}</td>
                        <td v-html="item.description"></td>
                        <td>{{ item.sort}}</td>
                        <td>{{ item.pub}}</td>

                        <td>
                            <a href="" @click.prevent="editItem(index)" class="btn btn-info btn-sm">
                                <i class="px-1 fas fa-edit"></i>
                            </a>
                            <a href="" @click.prevent="deleteItem(index)" class="btn btn-danger btn-sm">
                                <i class="px-1 fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</template>
<script>

    import Editor from '@tinymce/tinymce-vue'
    import {HTTP} from './../../mixins/http-common';
    import inputComponent from './BaseInput';
    import inputBooleanComponent from './BaseInputBoolean';
    import selectComponent from './BaseSelect';

    export default {
        props: ['items', 'selects', 'lang', 'model','products'],
        components: {
            'editor': Editor,
            inputComponent,
            inputBooleanComponent,
            selectComponent,
        },
        data() {
            return {
                item: {},
                errors: [],
                selectedItem: '',
                template: '',
                isEdit: false,
                list: [],
                templates: [],
                curLang: null,
                defaultLang: null
            }
        },

        mounted() {

        },
        created() {
            this.list = this.items.data;
            this.templates = this.selects;
            this.defaultLang = Object.keys(this.lang)[0];
            this.changeLang(this.defaultLang);
        },
        methods: {
            onChange(event) {
                this.item.template = this.templates[event.target.selectedIndex - 1].title;
            },
            changeLang(locale) {
                this.curLang = locale;
            },
            addItem() {
                if (!this.checkForm(this.item)) return;
                let url = "/admin/api/create/block";
                this.item.model_id = this.model.id;
                this.item.model_type = "App\\Article";
                let self = this;

                HTTP.post(url, this.item)
                    .then(function ({data}) {
                        console.log(data.status);
                        self.item.id = data.data.id;
                        self.item.image_url = data.data.image_url;
                        self.list.push(Object.assign({}, self.item));
                        self.clearForm();
                    })
                    .catch(e => {
                        alert(e.message)
                    })
            },
            deleteItem(index) {
                let self = this;
                let id = self.list[index].id
                let url = window.urlAjaxHandlerCms + 'delete/block/' + id;
                bootbox.setLocale(_LOCALE);
                bootbox.confirm("<h4>Are you sure?</h4>", function (confirmed) {
                    if (confirmed) {
                        console.log(self.list[index].id);
                        HTTP.get(url)
                            .then(function (response) {
                                // handle success
                                console.log(response);
                                if (response.data.status == 'ok') {
                                    self.list.splice(index, 1);
                                    self.clearForm();
                                } else alert(response.data.status);
                            })
                            .catch(function (error) {
                                // handle error
                                console.log(error);
                            })
                            .finally(function () {
                                // always executed
                            });
                    }
                });
            },
            updateItem() {
                if (!this.checkForm(this.item)) return;
                this.item.image = this.$refs.image_media_id.value;

                this.list[this.selectedItem] = Object.assign({}, this.item);
                let url = "/admin/api/update/block/" + this.item.id;
                let self = this;
                HTTP.post(url, this.item)
                    .then(function ({data}) {

                        self.clearForm();
                    })
                    .catch(e => {
                        //self.errors.push(e)
                        alert(e.message)
                        //self.showMessage(e.message, self.ERROR_CLASS);
                    })

            },
            aggiorna(a) {
                this.checkForm(a)
            },
            editItem(index) {
                this.resetToDefault();
                this.selectedItem = index;
                this.item = Object.assign({}, this.list[this.selectedItem]);
                this.updateTiny(this.item.description);
                this.$refs.image_media_id.value = this.item.image_media_id;
                this.isEdit = true;

            },
            clearForm() {
                this.item = {};
                this.template = "";
                this.isEdit = false;
                this.errors = [];
                this.clearTiny('');
                this.resetToDefault();

            },
            checkForm: function (item) {
                this.errors = [];
                if (!this.item.title) {
                    this.errors.push('Name required.');
                }
                if (!this.item.description) {
                    this.errors.push('Age required.');
                }
                if (this.errors.length > 0) alert('validate');
                else return true;

                //e.preventDefault();
            },
            setFocus: function () {
                // Note, you need to add a ref="search" attribute to your input.
                this.$refs.name.focus();
            },
            updateTiny: function (content) {
                tinymce.get('description').setContent(content);
            },
            clearTiny: function (content) {
                const lang = Object.keys(this.lang)
                for (const locale of lang) {
                    let target_element = (locale == this.defaultLang) ? `description` : `description_${locale}`;
                    tinymce.get(target_element).setContent(content);
                }
            },
            resetToDefault: function () {
                this.changeLang(this.defaultLang);
            },
            resetToDefault: function () {
                this.changeLang(this.defaultLang);
            }
        }
    }
</script>
