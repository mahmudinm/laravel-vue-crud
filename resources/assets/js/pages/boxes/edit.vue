<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="'Edit Item'">
        <form @submit.prevent="update" @keydown="form.onKeydown($event)">

          <!-- Price -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Items</label>
            <div class="col-md-7">
              <!-- <input v-model="form.price" :class="{ 'is-invalid': form.errors.has('price') }" class="form-control" type="text" name="price"> -->
              <select v-model="form.item_id" :class="{ 'is-invalid': form.errors.has('item_id') }" class="form-control" name="item_id">
                <option 
                  v-for="item in items" 
                  :value="item.id"
                  :selected="form.item_id">
                   {{ item.name }}
                </option>
              </select>
              <has-error :form="form" field="item_id"/>
            </div>
          </div>          

          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Name</label>
            <div class="col-md-7">
              <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
              <has-error :form="form" field="name"/>
            </div>
          </div>

          <!-- Weight -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Weight</label>
            <div class="col-md-7">
              <input v-model="form.weight" :class="{ 'is-invalid': form.errors.has('weight') }" class="form-control" type="text" name="weight">
              <has-error :form="form" field="weight"/>
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
    items: [],
    form: new Form({
      item_id: '',
      name: '',
      weight: ''
    })
  }),
  async mounted() {
    const { data } = await axios.get('/api/boxes/' + this.$route.params.id);
    // console.log(data[0].items.name);
    this.form.item_id = data[0].items.id
    // console.log(this.form.item_id)
    this.form.name = data[0].name
    this.form.weight = data[0].weight
    this.items = data[1]
  },
  methods: {
    async update () {
      await this.form.patch('/api/boxes/' + this.$route.params.id)

      this.$router.push({ name: 'boxes' })
    }
  }
}
</script>
