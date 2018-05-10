<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="'Create Item'">
        <form @submit.prevent="create" @keydown="form.onKeydown($event)">
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
                Create
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

export default {
  name: 'Edit',
  middleware: 'auth',

  data: () => ({
    form: new Form({
      name: '',
      price: '',
      description: ''
    })
  }),
  methods: {
    async create() {
      const data = await this.form.post('/api/items');
      this.$router.push({ name: 'items' })
    }
  }
}
</script>
