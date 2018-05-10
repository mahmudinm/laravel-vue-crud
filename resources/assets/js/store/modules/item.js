import axios from 'axios'
import Cookies from 'js-cookie'

// state
export const state = {
  items: [],
  item: []
}

// getters
export const getters = {
  getItems: state => state.items,
  getItem: state => state.item
}

// mutations
export const mutations = {
  fetchItemsSuccess (state, { items }) {
    state.items = items
  },
  fetchItemsFailure (state, { items }) {
    state.items = null
  },
  fetchItemSuccess (state, { item }) {
    state.item = item
  },
  fetchItemFailure (state, { item }) {
    state.item = null
  }
}

// actions
export const actions = {
  async fetchItems ({ commit }) {
    try {
      const { data } = await axios.get('/api/items')
      commit('fetchItemsSuccess', { items: data })
    } catch (e) {
      commit('fetchItemsFailure')
    }
  },
  async fetchItem ({ commit }, payload) {
    try {
      const { data } = await axios.get('/api/items/' + payload)
      commit('fetchItemSuccess', { item: data })
    } catch (e) {
      commit('fetchItemFailure')
    }
  },
  async storeItems (data) {
    const success = await axios.post('/api/items');    
  }
}
