<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="'Edit Item'">
        <form @submit.prevent="update" @keydown="form.onKeydown($event)">
          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Name</label>
            <div class="col-md-7">
              <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
              <has-error :form="form" field="name"/>
            </div>
          </div>

          <!-- Price -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Price</label>
            <div class="col-md-7">
              <input v-model="form.price" :class="{ 'is-invalid': form.errors.has('price') }" class="form-control" type="text" name="price">
              <has-error :form="form" field="price"/>
            </div>
          </div>

          <!-- Image -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Image</label>
            <div class="col-md-7">
              <input type="file" name="image" :class="{ 'is-invalid': form.errors.has('image') }" class="form-control" @change="selectFile">
              <has-error :form="form" field="image"/>
              <img v-if="form.image" :src="'http://localhost:8000/image/' + form.image" style="width: 200px; height: 200px; object-fit: cover;"> 
            </div>
          </div>

          <!-- Description -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Description</label>
            <div class="col-md-7">
              <textarea 
                  :class="{ 'is-invalid': form.errors.has('description') }"
                  class="form-control"
                  v-model="form.description">
              </textarea>
              <has-error :form="form" field="description"/>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button :loading="form.busy">
                Update
              </v-button>
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import axios from 'axios';

export default {
  name: 'Edit',
  middleware: 'auth',
  data: () => ({
    form: new Form({
      name: '',
      price: '',
      image: '',
      description: ''
    })
  }),
  methods: {
    async update () {
      await this.form.patch('/api/items/' + this.$route.params.id)

      this.$router.push({ name: 'items' })
    },
    selectFile(e) {      
      var fileReader = new FileReader()
      
      fileReader.readAsDataURL(e.target.files[0])

      fileReader.onload = (e) => {
          this.form.image = e.target.result
      }
    }
  },
  async mounted() {
    const { data } = await axios.get('/api/items/' + this.$route.params.id);
    this.form.keys().forEach(key => {
      this.form[key] = data[key]
    })
  }
}
</script>
