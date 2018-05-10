<template>
  <div>
    <router-link :to="{ name: 'home' }" class="btn btn-dark">
      Back
    </router-link>
    <router-link :to="{ name: 'items.new' }" class="btn btn-primary float-right">Create New</router-link>
    <br>
    <br>
    <card :title="'List Item'">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>#ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in items.data">
            <td>{{ item.id }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.price }}</td>
            <td>{{ item.description }}</td>
            <td>
              <router-link :to="{ name: 'items.edit', params: { id: item.id } }" class="btn btn-info btn-sm">Edit</router-link>
              <button @click="deleteItem(index, item.id)" class="btn btn-danger btn-sm">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
      <pagination :data="items" @pagination-change-page="getResults"></pagination>
    </card>    
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import axios from 'axios';
import swal from 'sweetalert2';
import pagination from 'laravel-vue-pagination';

export default {
  name: 'List',
  middleware: 'auth',
  data () {
    return {
      items:{}
    };
  },
  components: {
    pagination
  },
  async mounted() {
    // const { data } = await axios.get('/api/items');
    // this.items = data;
    this.getResults();
    // this.$store.dispatch('item/fetchItems');
  },
  methods: {
    async getResults(page = 1) {
      // const data = axios.get('/api/items?page=' + page)
      // console.log(data)
      // this.items = data;

      axios.get('/api/items?page=' + page)
        .then(response => {
          this.items = response.data;
          // console.log(response)
        });
    },    
    async deleteItem (index, someParam) {
      // this.$delete(this.items, index);
      // const data = await axios.delete('/api/items/' + someParam);      
      // const data = confirm('are you sure ?');
      const data = await swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      })

      if (data.value) {
        swal(
          'Deleted!',
          'Your file has been deleted.',
          'success'
        )
        await axios.delete('/api/items/' + someParam);
        this.$delete(this.items, index);
      }
    }
  }
}
</script>
