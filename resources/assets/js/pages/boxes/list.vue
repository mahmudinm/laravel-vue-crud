<template>
  <div>
    <router-link :to="{ name: 'home' }" class="btn btn-dark">
      Back
    </router-link>
    <router-link :to="{ name: 'boxes.new' }" class="btn btn-primary float-right">Create New</router-link>
    <br>
    <br>
    <card :title="'List box'">
      <table class="table table-hover">
        <thead>
          <tr>
            <td>#</td>
            <td>Name</td>
            <td>Weight</td>
            <td>Items Name</td>
            <td>Options</td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(box, index) in boxes.data">
            <td>{{ box.id }}</td>
            <td>{{ box.name }}</td>
            <td>{{ box.weight }}</td>
            <td>{{ box.items.name }}</td>
            <td>
              <router-link :to="{ name: 'boxes.edit', params: { id: box.id } }" class="btn btn-info btn-sm">Edit</router-link>
              <button @click="deleteItem(index, box.id)" class="btn btn-danger btn-sm">Delete</button>            
            </td>
          </tr>
        </tbody>
      </table>
    </card>    
  </div>
</template>

<script>
import axios from 'axios';
import swal from 'sweetalert2';

export default {
  name: 'List',
  data () {
    return {
      boxes:{}
    };
  },
  async mounted() {
    const data = await axios.get('/api/boxes');
    this.boxes = data.data;
  },
  methods: {
    async deleteItem (index, someParam) {
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
        await axios.delete('/api/boxes/' + someParam);
        this.$delete(this.boxes, index);
      }
    }
  }
}
</script>
